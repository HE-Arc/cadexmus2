@extends('layouts.app')

@section('content')
<form class="" action="{{ route('projet.store')}}" method="post">
    {{ csrf_field() }}
    nom : <input type="text" name="nom"><br>
    tempo : <input type="number" name="tempo" min="30" max="300"><br>
    <input type="submit">
</form>
@endsection
