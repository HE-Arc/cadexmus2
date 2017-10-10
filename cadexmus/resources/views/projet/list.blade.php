
    @if(count($myProjects))
        <h3>My Projects</h3>
        <ul class="nav  nav-stacked" >
        @foreach ($myProjects as $projet)
            <li id="projet_{{$projet->id}}"><a href="{{ route('projet.show',$projet->id)}}">{{ $projet->nom }}</a></li>
        @endforeach
        </ul>
    @elseif(count($otherProjects))
        <h3>Recent Projects</h3>
        <ul class="nav  nav-stacked" >
        @foreach ($otherProjects as $projet)
            <li id="projet_{{$projet->id}}"><a href="{{ route('projet.show',$projet->id)}}">{{ $projet->nom }}</a></li>
        @endforeach
        </ul>
    @endif
<a href="{{ route('projet.create')}}" class="btn btn-primary">Create project</a>
