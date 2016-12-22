
$(function () {

    var track_template = require("../../views/projet/track.hbs");
    var note_template = require("../../views/projet/note.hbs");
    var repr_template = require("../../views/projet/repr.hbs");

    var repr;

    versionActuelle = $('#title').data('version');
    projectUrl = $('#title').attr('href');
    userColor = $('#title').data('color');


    window.AudioContext = window.AudioContext || window.webkitAudioContext;
    var context = new AudioContext();

    context.suspend();

    /* tools */
    makeRepr();
    function makeRepr() {
        repr = {
            tempo: $("#tempo").val(),
            tracks: [],
            nbMesures: $("#nbMesures").val()
        };
        $(".track").each(function (i) {
            var track = {
                sample: {
                    name: $(this).find(".sample_name").text(),
                    url: $(this).find("audio").data('url')
                },
                volume: $(this).find('input[type="range"]').val(),
                notes: []
            };

            $(this).find(".note").each(function (j) {
                var note = {
                    pos: $(this).data("pos"),
                    len: $(this).data("len"),
                    color: $(this).data("color")
                };
                track.notes.push(note);
            });
            repr.tracks.push(track);
        });
    }
    var totalLen = 32*repr.nbMesures;

    /* persistance */

    $(".save").click(function () {
        if($('#title').data('as-guest')){
            alert("you are not in the project, you can't save");
            return;
        }
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
                $("#title").data('version', versionActuelle);
            }
            console.log(data.message);
            info(data.message);
        }).fail(function() {
            console.log("request failed");
        });
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
                $("#title").data("version",versionActuelle);
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
        if(!$("#autoRefresh").prop("checked"))
            $("#infos").text(data).show().fadeOut(1500);
    }

    function replaceTracks(repr){
        $("#repr").html(repr_template(repr));
        reinit();
        placeNotes();
        drawTimeBars();
        makeDraggableAndResizable();
    }






    /* Time bars */

    function drawTimeBars() {
        $(".gridbar").not("#timebar").remove();
        for(var i=0;i<100;i+=100/totalLen){
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
        var left = n.data('pos')*100/totalLen;
        var width= n.data('len')*100/totalLen;
        n.css({'left':left+'%','width':width+'%','top':0})
    }
    placeNotes();


    /* create and remove tracks and notes */

    var defaultLen = 2;

    $("#container").on("dblclick",".line",function(e){
        var pw = $(this).width();
        var pos = totalLen*e.offsetX/pw;
        if($("#modeMagnetisme").prop('checked'))
            pos = parseInt(pos);
        var newNote= note_template({
            pos:pos,
            len:defaultLen,
            color:userColor
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
        reinit();
    }

    function reinit(){
        resetTimebarSize();
        makeRepr();

        // si une track est ajoutée alors qu'on est en lecture
        if (context.state === "running"){
            // pause
            context.suspend().then(function () {
                // charge les AudioBuffers
                initBuffers().then(function(){
                    // play
                    context.resume();
                },function(e){
                    console.log(e);
                })
            })
        }else{
            initBuffers().then(init);
        }
    }

    $("#container").on("click",".remove_track",function () {
        $(this).parent().parent().parent().remove();
        resetTimebarSize();
    });

    $(".modal-dialog").on("click",".choosesample",function () {
        addTrack($(this).data("sample-name"), $(this).data("asset-url"));
        $("#myModal").modal("hide");
    });

    // gère l'évènement custom créé dans le script de sample.create
    $("#myModal").on("sampleloaded", function () {
        addTrack($("#newSampleName").val(), $("#newSampleUrl").val());
        $("#myModal").modal("hide");
    });

    // preview d'un sample
    $(".modal-dialog").on("click",".previewsample",function () {
        var btn = $(this);
        /* si on est déjà en train de préécouter, on arrête, sinon on lit le son */
        if(btn.hasClass("playing")){
            // [0] permet d'accéder à l'élément DOM
            $("#preview")[0].pause();
            $("#preview")[0].currentTime = 0;
        }else{
            var url = btn.parent().data("sample-url");
            $("#preview").attr('src',url)[0].play();
            btn.addClass("playing");
            $("#preview").on("pause",function(){
                btn.removeClass("playing");
            });
        }
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
                var pos = totalLen*x/pw;
                if($("#modeMagnetisme").prop('checked'))
                    pos = parseInt(pos+.5);
                $(this).data('pos',pos);
                if(x<0 || x>= pw)
                    $(this).remove();
                placeNote($(this));
                $(this).removeClass().addClass("note note"+userColor);
                $(this).data("color",userColor);
            }
        }).resizable({
            handles: "e", // ne prend en charge que le côté droit (east)
            stop:function(event,ui){
                var pw = $(this).parent().width();
                var len = totalLen*ui.size.width/pw;
                if($("#modeMagnetisme").prop('checked'))
                    var len = parseInt(len+.5);
                if(len==0)len=1;
                defaultLen = len;
                $(this).data("len",len);
                placeNote($(this));
                $(this).removeClass().addClass("note note"+userColor);
                $(this).data("color",userColor);
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

    // zoom

    var zoomLevel = 0;
    var zoomFactor = 4/3;

    $("#container").on("click",".btnZoomIn",function(){
        zoom(zoomFactor);
        zoomLevel++;
    });

    $("#container").on("click",".btnZoomOut",function(){
        if (zoomLevel > 0){
            zoom(1/zoomFactor);
            zoomLevel--;
        }else{
            $('#grid').css('width','100%');
        }
    });

    function zoom(factor){
        $('#grid').css('width',function( index, value ) {
            var newWidth = parseFloat(value)*factor;
            var parentWidth = parseInt($(this).parent().css('width'));
            var percentage = 100*newWidth/parentWidth;
            return percentage+'%';
        })
    }

    // change sequence length

    $("#container").on("click",".btnExpand", function(){
        multSequence(2);
    });

    $("#container").on("click",".btnDuplicate", function(){

        // crée des double des notes
        $('.note').each(function(){
            var newPos = parseFloat($(this).data('pos'))+totalLen;
            $(this).parent().append(
                $('<div></div>')
                    .data({ pos : newPos })
                    .data({ len : $(this).data('len') })
                    .data({ color : $(this).data('color') })
                    .addClass($(this).attr('class'))
            );
        });

        multSequence(2);
    });

    $("#container").on("click",".btnDivide",function(){
        multSequence(1/2);
        // todo: plutot que supprimer les notes, ne pas les insérer dans makeRepr()
        // supprime les notes qui sont en dehors
        $('.note').each(function(){
            if ($(this).data('pos') >= totalLen){
                $(this).remove();
            }
        });
        // il faut remakerepr
        makeRepr();
    });

    function multSequence(factor){
        $("#nbMesures").val(function( i, val ) {
            return val*factor;
        });
        makeRepr();
        totalLen = 32*repr.nbMesures;
        drawTimeBars();
        placeNotes();
        makeDraggableAndResizable();
    }






    /* Player */

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

    $("#container").on("click",".btnPausePlay",function(){
        if (context.state === "running") {
            context.close().then(function() {
                clearTimeout(timeout)
            })
        } else {
            context = new AudioContext();
            currentTime = context.currentTime;
            context.resume().then(function(){
                requestAnimationFrame(animation);
                play();
            });
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
                    console.error(track.sample.url, error);
                    reject(error);
                });
            })
            resolve();
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
                var vol = parseFloat(track.volume);
                s.gain.gain.value = vol;
                s.gain.gain.linearRampToValueAtTime(vol, end - fade);
                s.gain.gain.linearRampToValueAtTime(0, end);
            });
        });

        if (context.state === "running") {
            var avance = now - (context.currentTime);

            // fait en sorte que l'avance reste autour de 500ms
            currentTime = now + barLen*repr.nbMesures;
            timeout = setTimeout(play, (repr.nbMesures*barLen - (.5 - avance)) * 1000);
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
        var progress = context.currentTime%(barLen*repr.nbMesures);
        var percentage = 100*progress/(barLen*repr.nbMesures);

        $("#timebar").css('left',percentage+'%');

        if (context.state === "running")
            requestAnimationFrame(animation);
        else
            $("#timebar").css('left','0%');
    }

});
