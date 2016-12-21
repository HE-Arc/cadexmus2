
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./projet.show')
require('./invite')

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var projet = $('h1 a[data-version]');
    if (projet.length) {
        var versionActuelle = projet.data('version')|0;
        var projectUrl = projet.attr('href');
        var userColor = projet.data('color');

        $('.modal-dialog').on('submit','#searchSampleForm', function(event){
            event.preventDefault();

            var pattern = $("#search-pattern").val();

            $.get($(this).attr('action'), {pattern: pattern}).done(function(data){
                $("#sample-list").html(data);
            });
        });
    }
});
