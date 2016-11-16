@extends('layouts.app')

@section('content')
<form class="" action="{{ route('sample.store')}}" method="post"  enctype="multipart/form-data">
    {{ csrf_field() }}
    url : <input type="file" name="url"  accept="audio/*">
    type : <input type="text" name="type">
    nom : <input type="text" name="nom">
    <input type="submit">
</form>
@endsection
