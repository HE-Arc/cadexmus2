@extends('layouts.app')

@section('content')

@foreach ($samples as $s)
    <p>{{ $s->id }} : {{ $s->nom }}</p>
	<audio controls>
		<source src="uploads/{{$s->url}}">
	</audio>
@endforeach
<br>
<a href="{{ route('sample.create')}}">upload sample</a>

@endsection
