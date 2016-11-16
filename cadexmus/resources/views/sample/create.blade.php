@extends('layouts.app')

@section('content')
<form class="" action="{{ route('sample.store')}}" method="post"  enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="url"  accept="audio/*">
    <label for="name">type : </label> <input type="text" name="type"><br>
    <label for="name">nom : </label> <input type="text" name="nom"><br>
    <input type="submit">
</form>
@endsection
