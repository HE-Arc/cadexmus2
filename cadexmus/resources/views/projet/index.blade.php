@extends('layouts.app')

@section('content')
    <main>
        <h1>My Projects</h1>
            <ul>
                @foreach ($myProjects as $projet)
                    <li><a href="{{ route('projet.show',$projet->id)}}">{{ $projet->nom }}</a></li>
                @endforeach
            </ul>
        <a href="{{ route('projet.create')}}" class="btn btn-primary">Create a project</a>
        <hr>
        <h1>Recent Projects</h1>
            <ul>
                @foreach ($otherProjects as $projet)
                    <li><a href="{{ route('projet.show',$projet->id)}}">{{ $projet->nom }}</a></li>
                @endforeach
            </ul>
    </main>
@endsection