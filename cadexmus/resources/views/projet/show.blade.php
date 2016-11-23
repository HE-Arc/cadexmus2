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
            <button>remove</button>
            <ul>
                @foreach($track["notes"] as $note)
                <li class="note">
                    pos:<input type="number" value="{{$note["pos"]}}">,
                    len:<input type="number" value="{{$note["len"]}}">
                    <button>remove</button>
                </li>
                @endforeach
                <li><button>add note</button></li>
            </ul>
        </li>
    @endforeach
        <li>
            <p>
                Sample name :
                <input type="text" name="samplename">
                URL :
                <input type="text" name="sampleurl">
                <button onclick="addTrack()">add track</button>
            </p>
        </li>
    </ul>

    <button onclick="save()">Save</button>


    <script>
        function addTrack(btn){

        }

        function save() {
            alert("saving");
        }
    </script>
@endsection
