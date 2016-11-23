@extends('layouts.app')

@section('content')
    <?php $version = $projet->versions->first() ?>
    <h1>Projet {{ $projet->nom }}</h1>
    <h2>Version {{$version->numero}}</h2>

    <p>tempo : <input type="number" value="{{$version->repr["tempo"]}}"></p>
    <ul id="tracks">
    @foreach ($version->repr["tracks"] as $track)
        <li class="track">
            {{ $track["sample"]["name"] }}
            <audio controls src="{{asset("uploads")}}/{{$track["sample"]["url"]}}" style="vertical-align: middle"></audio>
            <button class="removetrack">remove track</button>
            <ul>
                @foreach($track["notes"] as $note)
                <li class="note">
                    pos:<input type="number" value="{{$note["pos"]}}">,
                    len:<input type="number" value="{{$note["len"]}}">
                    <button class="removenote">remove note</button>
                </li>
                @endforeach
                <li><button class="addnote">add note</button></li>
            </ul>
        </li>
    @endforeach
        <li>
            <p>
                Sample name :
                <input type="text" id="samplename">
                URL :
                <input type="text" id="sampleurl" value="samples/native/kick1.wav">
                <button class="addtrack">add track</button>
            </p>
        </li>
    </ul>

    <button class="save">Save</button>


    <script>
        $(function() {

            $(".save").click(function () {
                console.log("saving");
            });

            $(".addtrack").click(function () {
                var sampleName = $("#samplename").val();
                var sampleUrl = $("#sampleurl").val();
                var newTrack =
                    '<li class="track">'+
                        sampleName +
                        '<audio controls src="{{asset("uploads")}}/'+sampleUrl+'" style="vertical-align: middle"></audio>'+
                        '<button class="removetrack">remove track</button>'+
                        '<ul>'+
                            '<li><button class="addnote">add note</button></li>'+
                        '</ul>'+
                    '</li>';
                $(".track:last").after(newTrack);
            });

            // $("addnote").click() ne fonctionne que sur les éléments qui existent déjà
            $("#tracks").on("click",".addnote",function () {
                var newNote='<li class="note">pos:<input type="number" value="0">, len:<input type="number" value="1"><button class="removenote">remove note</button></li>'
                $(this).before(newNote);
            });

            // pareil pour $(".removetrack, .removenote").click()
            $("#tracks").on("click",".removetrack, .removenote",function () {
                console.log("yo")
                $(this).parent().remove();
            });

        });
    </script>
@endsection
