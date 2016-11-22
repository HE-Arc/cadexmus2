@extends('layouts.app')

@section('content')
    <?php $version = $projet->versions->first() ?>
    <h1>Projet {{ $projet->nom }}</h1>
    <h2>Version {{$version->numero}}</h2>

    <p>tempo : {{$version->repr["tempo"]}}</p>
    <ul>
        @foreach ($version->repr["tracks"] as $track)
            <li>{{ $track["sample"]["name"] }}
            <ul>
                @foreach($track["notes"] as $note)
                    <li>pos:{{$note["pos"]}}, len:{{$note["len"]}}</li>
                @endforeach
            </ul>
            </li>
        @endforeach
    </ul>
@endsection
