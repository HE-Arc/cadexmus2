@extends('layouts.app')

@section('content')
    <?php $version = $projet->versions[0] ?>
    <h1>Projet {{ $projet->nom }}</h1>
    <h2>Version {{$version->numero}}</h2>

    <p>tempo : <input id="tempo" type="number" value="{{$version->repr["tempo"]}}"></p>
    <ul id="tracks">
    @foreach ($version->repr["tracks"] as $track)
        <li class="track">
            {{ $track["sample"]["name"] }}
            <input type="hidden" class="sample_url" value="{{$track["sample"]["url"]}}">
            <input type="hidden" class="sample_name" value="{{$track["sample"]["name"]}}">
            <audio controls src="{{asset("uploads")}}/{{$track["sample"]["url"]}}" style="vertical-align: middle"></audio>
            <button class="removetrack">remove track</button>
            <ul>
                @if (isset($track["notes"]))
                    @foreach($track["notes"] as $note)
                        <li class="note">
                            pos:<input class="note_pos" type="number" value="{{$note["pos"]}}">,
                            len:<input class="note_len" type="number" value="{{$note["len"]}}">
                            <button class="removenote">remove note</button>
                        </li>
                    @endforeach
                @endif
                <li><button class="addnote">add note</button></li>
            </ul>
        </li>
    @endforeach
    </ul>
    <p>
        New track :
        <button data-toggle="modal" data-target="#myModal">choose sample</button>
    </p>


    <button class="save">Save</button>


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



    <script>
        $(function() {
            function addSample(sampleName,sampleUrl){
                var newTrack =
                    '<li class="track">'+
                        sampleName +
                        '<audio controls src="{{asset("uploads")}}/'+sampleUrl+'" style="vertical-align: middle"></audio>'+
                        '<button class="removetrack">remove track</button>'+
                        '<ul>'+
                            '<li><button class="addnote">add note</button></li>'+
                        '</ul>'+
                    '</li>';
                $("#tracks").append(newTrack);
            }

            // $("addnote").click() ne fonctionne que sur les éléments qui existent déjà
            $("#tracks").on("click",".addnote",function () {
                var newNote=
                    '<li class="note">'+
                        'pos:<input class="note_pos" type="number" value="0">,'+
                        'len:<input class="note_len" type="number" value="1">'+
                        '<button class="removenote">remove note</button>'+
                    '</li>';
                $(this).before(newNote);
            });

            // pareil pour $(".removetrack, .removenote").click()
            // on trigger l'évènement sur l'élément #tracks, et on descend jusqu'à un élément .remove*
            $("#tracks").on("click",".removetrack, .removenote",function () {
                $(this).parent().remove();
            });



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
                console.log(repr);

                $.ajax({
                    type: "PUT",
                    url: "{{ route('projet.update',$projet->id)}}",
                    data: {
                        repr:repr,
                        version:"{{$version->numero}}"
                    }
                })
                .done(function(data) {
                    console.log(data)
                })
                .fail(function() {
                    console.log("request failed")
                });
                //location.reload();
            });

            // charge le contenu de la boîte modale
            $.get("{{ route('sample.index') }}").done(function(data){
                $(".modal-body").html(data);
            });

            $(".modal-body").on("click",".sample",function () {
                addSample($(this).attr("sampleName"),$(this).attr("sampleUrl"));
                $("#myModal").modal("hide");
            });

        });
    </script>
@endsection
