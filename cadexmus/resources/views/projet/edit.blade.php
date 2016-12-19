<?php 
    $version = $projet->versions[0];
    $users = $projet->users;
?>
@foreach ($users as $user)
    <img title="{{ $user->name }}" alt="{{ $user->name }}'s profile picture" class="img-circle img-user{{($user->pivot->couleur-1)%8}}" src="../uploads/picture/profile/{{$user->picture}}">
@endforeach

<h1>{{ $projet->nom }}</h1>
<!--<h2>Version <span id="version">{{$version->numero}}</span></h2>-->

<div id="repr">
    @include("projet.repr", $version->repr)
</div>
<hr>
<button class="save btn">Save</button>
<button class="refresh btn">Refresh</button> <span id="infos"></span>
<br>
<input type="checkbox" id="autoRefresh"> automatic refresh


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        liste de samples ici
    </div>
</div>

<script>
    var versionActuelle = {{$version->numero}};
    var projectUrl = "{{ route('projet.show',$projet->id) }}";
    var userColor = {{$userColor or 7}};
    var asGuest = {{$asGuest or "false"}};

    $(function () {
        // charge le contenu de la boîte modale
        $.get("{{ route('sample.index') }}").done(function(data){
            $(".modal-dialog").html(data);
        });

        $('.modal-dialog').on('submit','#searchSampleForm', function(event){
            event.preventDefault();

            var pattern = $("#search-pattern").val();

            // petit trick pour palier au bug de
            // http://localhost/cadexmus2/cadexmus/public/sample/filter/ -> http://localhost/sample/filter
            // qu'on ne devrait plus avoir en production
            if(pattern != "")
                pattern = '/'+pattern;

            $.get("{{ route('sample.index') }}/filter"+pattern).done(function(data){
                $("#sample-list").html(data);
            });

        });

    });
</script>

<script src="{{ asset('js/projet.show.js')}}"></script>
