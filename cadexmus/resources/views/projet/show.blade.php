@extends('layouts.app')

@section('content')
    <?php $version = $projet->versions[0] ?>
    <h1>Projet {{ $projet->nom }}</h1>
    <h2>Version <span id="version">{{$version->numero}}</span></h2>

    <div id="repr">
        @include("projet.repr", $version->repr)
    </div>

    <button class="save">Save</button>
    <button class="refresh">Refresh</button>
    <p id="infos"></p>
    <p id="debug"></p>


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose sample</h4>
                </div>
                <div class="modal-body" style="max-height:50vh;overflow: auto">
                    liste de samples ici
                </div>
            </div>

        </div>
    </div>
    <div class="chat">
        chat ici
    </div>

    <script>
        $(function () {

            // charge le contenu de la boîte modale
            $.get("{{ route('sample.index') }}").done(function(data){
                $(".modal-body").html(data);
            });

        });
    </script>

@endsection
