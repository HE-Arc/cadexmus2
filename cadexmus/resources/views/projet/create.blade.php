@extends('layouts.app')

@section('content')
<form class="" action="{{ route('projet.store')}}" method="post">
    {{ csrf_field() }}
    nom : <input type="text" name="nom"><br>
    <input type="submit">
</form>
@endsection
