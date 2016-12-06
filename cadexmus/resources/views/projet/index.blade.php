
<p>
    <a href="{{ route('projet.create')}}">create</a>

    <ul>
    @foreach ($projets as $projet)
        <li><a href="{{ route('projet.show',$projet->id)}}">{{ $projet->nom }}</a></li>
    @endforeach
    </ul>
</p>

