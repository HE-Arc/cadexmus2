@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    <a href="{{ route('sample.create')}}">create</a>
=======

@foreach ($samples as $s)
    <p>{{ $s->id }} : {{ $s->nom }}</p>
	<audio controls>
		<source src="uploads/{{$s->url}}">
	</audio>
@endforeach
<br>
<a href="{{ route('sample.create')}}">upload sample</a>
>>>>>>> 6e44632add2d1a481344a830570ff8f76c0ebb60
@endsection
