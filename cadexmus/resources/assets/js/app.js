
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    $(".refresh").click(function(){
        $.ajax({
            type: "GET",
            url: getUpdateUrl
        }).done(function(data) {
            if(data=="ok"){
                info("déjà à jour");
            }else{
                replaceTracks(data);
            }
        }).fail(function() {
            console.log("request failed");
        });
    });


    function info(data){
        $("#infos").text(data);
        $("#infos").show();
        $("#infos").fadeOut(3000);
    }

});

