<?php $version = $projet->versions[0] ?>
<h1>{{ $projet->nom }}</h1>
<h2>Version <span id="version">{{$version->numero}}</span></h2>

<div id="repr">
    @include("projet.repr", $version->repr)
</div>
<hr>
<button class="save btn">Save</button>
<button class="refresh btn">Refresh</button> <span id="infos"></span>
<br>
<input type="checkbox" id="autoRefresh"> automatic refresh

<p id="debug"></p>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="color:#555">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choose sample</h4>
            </div>
            <div class="modal-body" style="max-height:50vh;overflow: auto">
                liste de samples ici
            </div>
            <div class="modal-footer" style="text-align:initial">
                @include('sample.create')
            </div>
        </div>

    </div>
</div>

<script>
    var versionActuelle = {{$version->numero}};
    var projectUrl = "{{ route('projet.show',$projet->id) }}";

    $(function () {
        // charge le contenu de la boîte modale
        $.get("{{ route('sample.index') }}").done(function(data){
            $(".modal-body").html(data);
        });

    });
</script>

<script src="{{ asset('js/projet.show.js')}}"></script>
