@extends('layouts.app')

@section('content')
<p>
    <a href="{{ route('projet.create')}}">create</a>

    @foreach ($projets as $projet)
        <p>Projet : {{ $projet->nom }}</p>
    @endforeach
</p>
@endsection
