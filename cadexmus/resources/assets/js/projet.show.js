
$(function () {

    var track_template = require("../../views/projet/track.hbs");
    var note_template = require("../../views/projet/note.hbs");
    var repr_template = require("../../views/projet/repr.hbs");

    function addSample(name, url){
        var newTrack = track_template({
            sample: {
                name: name,
                url: url
            }
        });
        $("#tracks").append(newTrack);
    }

    // $("addnote").click() ne fonctionne que sur les éléments qui existent déjà
    $("#tracks").on("click",".addnote",function () {
        var newNote= note_template({
            pos:0,len:1
        });
        $(this).before(newNote);
    });

    // pareil pour $(".removetrack, .removenote").click()
    // on trigger l'évènement sur l'élément #tracks, et on descend jusqu'à un élément .remove*
    $("#tracks").on("click",".removetrack, .removenote",function () {
        $(this).parent().remove();
    });

    $(".modal-body").on("click",".sample",function () {
        addSample($(this).attr("sampleName"),$(this).attr("sampleUrl"));
        $("#myModal").modal("hide");
    });

    function replaceTracks(repr){
        $("#repr").html(repr_template(repr));
    }


    $(".save").click(function () {
        var repr ={
            tempo: $("#tempo").val(),
            tracks:[]
        };
        $(".track").each(function(i) {
            var track = {
                sample:{
                    url:$(this).children(".sample_url").val(),
                    name:$(this).children(".sample_name").val()
                },
                notes:[]
            };

            $(this).find(".note").each(function(j){
                var note = {
                    pos: $(this).children(".note_pos").val(),
                    len: $(this).children(".note_len").val()
                };
                track.notes.push(note);
            });

            repr.tracks.push(track);
        });

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

    $(".refresh").click(function(){
        refresh();
    });


    function info(data){
        $("#infos").text(data);
        $("#infos").show();
        $("#infos").fadeOut(1500);
    }

    function refresh() {
        $.ajax({
            type: "GET",
            url: projectUrl + "/" + versionActuelle
        }).done(function (data) {
            if (data === 0) {
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
});
