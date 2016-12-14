
$(function () {

    var track_template = require("../../views/projet/track.hbs");
    var note_template = require("../../views/projet/note.hbs");
    var repr_template = require("../../views/projet/repr.hbs");

    var repr;

    /* tools */
    makeRepr();
    function makeRepr() {
        repr = {
            tempo: $("#tempo").val(),
            tracks: []
        };
        $(".track").each(function (i) {
            var track = {
                sample: {
                    name: $(this).find(".sample_name").text(),
                    url: $(this).find("audio").attr('data-url')
                },
                notes: []
            };

            $(this).find(".note").each(function (j) {
                var note = {
                    pos: $(this).attr("pos"),
                    len: $(this).attr("len")
                };
                track.notes.push(note);
            });

            repr.tracks.push(track);
        });
    }

    /* persistance */

    $(".save").click(function () {
        makeRepr();

        $.ajax({
            type: "PUT",
            url: projectUrl,
            data: {
                repr:repr,
                version:versionActuelle
            }
        }).done(function(data) {
            if(data.version != "undefined"){
                versionActuelle=data.version;
                $("#version").html(versionActuelle);
            }
            console.log(data.message);
            info(data.message);
        }).fail(function() {
            console.log("request failed");
        });
        //location.reload();
    });

    $(".refresh").click(refresh);

    function refresh() {
        $.ajax({
            type: "GET",
            url: projectUrl + "/" + versionActuelle
        }).done(function (data) {
            if (data == 0) {
                info("déjà à jour");
            } else {
                versionActuelle = data.numero;
                replaceTracks(data.repr);
                $("#version").html(versionActuelle);
            }
        }).fail(function () {
            console.log("request failed");
        });
    }

    var interval;

    $("#autoRefresh").change(function(){
        if($(this).prop('checked')){
            interval = setInterval(refresh, 2000);
        }else{
            clearInterval(interval);
        }
    });

    function info(data){
        $("#infos").text(data);
        $("#infos").show();
        $("#infos").fadeOut(1500);
    }

    function replaceTracks(repr){
        $("#repr").html(repr_template(repr));
        placeNotes();
        drawTimeBars();
        makeDraggableAndResizable();
    }






    /* Time bars */

    function drawTimeBars() {
        for(var i=0;i<100;i+=100/32){
            var type= (i%(100/8)==0?(i%(100/4)==0?"gridbar4":"gridbar8"):"gridbar32");
            $(".barline").append('<div class="gridbar '+type+'" style="left:'+i+'%"></div>')
        }
        resetTimebarSize();
    }

    function resetTimebarSize(){
        $(".gridbar").height($("#grid").height()-1);
    }

    drawTimeBars();


    /* Notes positions */

    function placeNotes(){
        $('.note').each(function(){
            placeNote($(this));
        });
    }
    function placeNote(n){
        var left = n.attr('pos')*100/32;
        var width= n.attr('len')*100/32;
        n.css({'left':left+'%','width':width+'%','top':0})
    }
    placeNotes();


    /* create and remove tracks and notes */

    $("#container").on("dblclick",".line",function(e){
        var pw = $(this).width();
        var pos = parseInt(32*e.offsetX/pw);
        var newNote= note_template({
            pos:pos,len:1
        });
        $(this).append(newNote);
        // todo: placeNote(newNote) avec newNote un élément dom
        placeNotes();
        // todo: idem, ne pas faire ça sur toutes les notes mais que les nouvelles
        makeDraggableAndResizable();
    });

    $("#container").on("dblclick",".note",function(e){
        $(this).remove();
        e.stopPropagation();
    });

    function addTrack(name, url){
        var newTrack = track_template({
            sample: {
                name: name,
                url: url
            }
        });
        $("#grid").append(newTrack);
        resetTimebarSize();
        makeRepr();
        context.suspend().then(function () {
            initBuffers().then(function(){
                context.resume();
            })
        })
    }

    $("#container").on("click",".remove_track",function () {
        $(this).parent().parent().remove();
        resetTimebarSize();
    });

    $(".modal-body").on("click",".sample",function () {
        addTrack($(this).attr("sampleName"),$(this).attr("sampleUrl"));
        $("#myModal").modal("hide");
    });



    /* jquery.ui draggable and resisable */

    function makeDraggableAndResizable(){
        $(".note").draggable({
            axis:"x",
            //snap: true,
            //snap: ".gridbar",
            //snapTolerance: 5,
            stop:function(event,ui){
                var pw = $(this).parent().width();
                var x=ui.position.left;
                var pos = parseInt((32*x/pw)+0.5);
                $(this).attr('pos',pos);
                if(x<0 || x>= pw)
                    $(this).remove();
                placeNote($(this));
            }
        }).resizable({
            handles: "e", // ne prend en charge que le côté droit (east)
            stop:function(event,ui){
                var pw = $(this).parent().width();
                var len = parseInt((32*ui.size.width/pw)+.5);
                if(len==0)len=1;
                $(this).attr("len",len);
                placeNote($(this));
            }
        });
    }
    makeDraggableAndResizable();


    /* UI */

    // au survol du nom du sample, afficher le bouton de suppression de la ligne
    $("#container").on("mouseenter mouseleave", "td.track_header", function(){
        // la propriété display:none est inversée sur les 2 enfants
        $(this).children().toggle();
    });







    /* Player */

    window.AudioContext = window.AudioContext || window.webkitAudioContext;
    var context = new AudioContext();

    context.suspend();

    // tableau associatif clé: url du sample, valeur: objet AudioBuffer retourné par loadSound()
    var buffers = [];

    var timeout;
    var currentTime;

    // memento
    /*
    var bpm=120; // ==tempo
    var beatLen = 60.0 / bpm; // ==seconds per beat
    var unit = barLen/32; // ==beatLen/8
    */
    var barLen = 240/repr.tempo;; //sec // ==beatLen*4
    var fade = 1/128; // arbitraire

    $(".btnPausePlay").click(function(){
        if (context.state === "running") {
            context.close().then(function() {
                clearTimeout(timeout)
            })
        } else {
            context = new AudioContext();
            currentTime = context.currentTime;
            requestAnimationFrame(animation);
            play();
        }
        $(".btnPausePlay").toggle();
    });

    function loadSound(url) {
        return new Promise(function(resolve, reject){
            var request = new XMLHttpRequest();
            request.open('GET', url, true);
            request.responseType = 'arraybuffer';
            request.onload = function() {
                // Asynchronously decode the audio file data in request.response
                context.decodeAudioData(
                    request.response,
                    function(buffer) {
                        if (buffer) {
                            resolve(buffer)
                        } else {
                            reject('error decoding file data: ' + url)
                        }
                    },
                    function(error) {
                        reject('decodeAudioData error: ' + error)
                    }
                )
            };
            request.send()
        })
    }

    // init buffers
    function initBuffers(){
        return new Promise(function(resolve,reject){
            var nbSonsCharges=0;
            repr.tracks.forEach(function(track){
                loadSound("../uploads/" + track.sample.url).then(function(buffer){
                    console.log(track.sample.url, "is loaded")
                    buffers[track.sample.url] = buffer;
                    nbSonsCharges++;
                    if(nbSonsCharges==repr.tracks.length){
                        //init();
                        resolve();
                    }
                }, function(error) {
                    //console.error(track.sample.url, error);
                    reject(error);
                });
            })
        })
    }

    initBuffers().then(init);

    function init(){
        console.log("ready");
    }

    function play(){
        var now = currentTime;

        makeRepr();
        barLen = 240/repr.tempo;
        var unit = barLen/32;

        repr.tracks.forEach(function(track){
            track.notes.forEach(function(note){
                // on recrée la source à chaque fois car on ne peux pas appeler start() plusieurs fois sur la même source
                s = sound(buffers[track.sample.url]);
                s.source.start(now + unit*note.pos);
                end = now +unit*note.pos + unit*note.len;
                s.source.stop(end);
                s.gain.gain.linearRampToValueAtTime(1, end - fade);
                s.gain.gain.linearRampToValueAtTime(0, end);
            });
        });

        if (context.state === "running") {
            var avance = now - (context.currentTime);

            // fait en sorte que l'avance reste autour de 500ms
            currentTime = now + barLen;
            timeout = setTimeout(play, (barLen - (.5 - avance)) * 1000);
        }
    }

    function sound(buffer) {
        var source = context.createBufferSource()
        var gain = context.createGain()
        source.buffer = buffer
        source.connect(gain)
        gain.connect(context.destination)
        return {source: source, gain: gain}
    }

    /* animation */

    window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
        window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;

    function animation(timestamp) {
        var progress = context.currentTime%barLen;
        var percentage = 100*progress/barLen;

        $("#timebar").css('left',percentage+'%');

        if (context.state === "running")
            requestAnimationFrame(animation);
        else
            $("#timebar").css('left','0%');
    }

});
