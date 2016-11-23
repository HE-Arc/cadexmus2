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
        New track : Sample name :
        <input type="text" id="samplename">
        URL :
        <input type="text" id="sampleurl" value="samples/native/kick1.wav">
        <button class="addtrack">add track</button>
    </p>


    <button class="save">Save</button>


    <script>
        $(function() {

            $(".addtrack").click(function () {
                var sampleName = $("#samplename").val();
                var sampleUrl = $("#sampleurl").val();
                var newTrack =
                    '<li class="track">'+
                        sampleName +
                        '<input type="hidden" class="sample_url" value="'+sampleUrl+'">'+
                        '<input type="hidden" class="sample_name" value="'+sampleName+'">'+
                        '<audio controls src="{{asset("uploads")}}/'+sampleUrl+'" style="vertical-align: middle"></audio>'+
                        '<button class="removetrack">remove track</button>'+
                        '<ul>'+
                            '<li><button class="addnote">add note</button></li>'+
                        '</ul>'+
                    '</li>';
                $("#tracks").append(newTrack);
            });

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

        });
    </script>
@endsection
