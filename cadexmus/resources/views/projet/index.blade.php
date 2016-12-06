@extends('layouts.app')

@section('content')
<p>
    <a href="{{ route('projet.create')}}">create</a>

    <ul>
    @foreach ($projets as $projet)
        <li><a href="{{ route('projet.show',$projet->id)}}">{{ $projet->nom }}</a></li>
    @endforeach
    </ul>
</p>
@endsection


@section('invite')
                <form style="margin: 0 10px 0 0">
                    <input type="text"  class="form-control" placeholder="Email du collaborateur">
                </form>
@endsection