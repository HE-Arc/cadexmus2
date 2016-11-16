@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    <a href="{{ route('sample.create')}}">create</a>
=======

@foreach ($samples as $s)
    <p>{{ $s->id }} : {{ $s->nom }}</p>
@endforeach

<a href="{{ route('sample.create')}}">upload sample</a>
>>>>>>> 6e44632add2d1a481344a830570ff8f76c0ebb60
@endsection
