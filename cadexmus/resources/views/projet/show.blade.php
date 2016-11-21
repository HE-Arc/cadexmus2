@extends('layouts.app')

@section('content')
    <h1>Projet {{ $projet->nom }}</h1>
    <h2>Version {{$version->numero}}</h2>
    <code>{{ $version->repr }}</code>
@endsection
