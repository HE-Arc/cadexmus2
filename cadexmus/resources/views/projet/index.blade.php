
<h3>Mes projets</h3>
<ul class="nav  nav-stacked" >
    @foreach ($projets as $projet)
        <li id="projet_{{$projet->id}}"><a href="{{ route('projet.show',$projet->id)}}">{{ $projet->nom }}</a></li>
    @endforeach
</ul>
<a href="{{ route('projet.create')}}" class="btn btn-primary">Créer un projet</a>
