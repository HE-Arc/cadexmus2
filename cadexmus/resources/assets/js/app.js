
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

    var track_template = require("../../views/track_template.hbs");
    var note_template = require("../../views/note_template.hbs");

    function addSample(sampleName,sampleUrl){
        var newTrack = track_template({
            sampleName:sampleName,
            sampleUrl:sampleUrl
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

});

