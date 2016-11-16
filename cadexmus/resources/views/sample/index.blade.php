@extends('layouts.app')

@section('content')

@foreach ($samples as $s)
    <p>{{ $s->id }} : {{ $s->nom }}</p>
@endforeach

<a href="{{ route('sample.create')}}">upload sample</a>
@endsection
