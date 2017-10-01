@extends('layouts.app')

@section('content')
<form class="" action="{{ route('projet.store')}}" method="post">
    {{ csrf_field() }}
    <p>
        Name : <input type="text" name="nom">
    </p>
    <p>
        <input type="submit">
    </p>
</form>
@endsection
