@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="about">
            <h1>Cadexmus</h1>
            <p>
                Cadexmus is a collaborative music creation platform, still under development for now.<br>
                Feel free to report issues here : <a href="https://github.com/HE-Arc/cadexmus2/issues">github.com/HE-Arc/cadexmus2/issues</a>

            </p>
            <p>Background artwork by Charlie Tapster : <a href="http://nervewax.com/the-grid">nervewax.com/the-grid</a></p>
        </div>
        <h1>My Projects</h1>
        <table class="projects table table-inverse table-condensed">
            <thead>
                <tr>
                    <th>Project name</th>
                    <th>Collaborators</th>
                    <th>Versions</th>
                    <th>Last update</th>
                    <th>Quit</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($myProjects as $projet)
                <tr>
                    <td class="first-cell">
                        <a href="{{ route('projet.show',$projet->id) }}">
                            <strong>{{ $projet->nom }}</strong>
                        </a>
                    </td>
                    <td>
                        @foreach ($projet->users as $user)
                            {{ $user->name }}
                            @if (! $loop->last)
                                -
                            @endif
                        @endforeach
                    </td>
                    <td>
                        {{ count($projet->versions)  }}
                    </td>
                    <td>
                        {{ $projet->updated_at  }}
                    </td>
                    <td class="actions-cell">
                        <form action="{{ route('projet.destroy', $projet->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn quitproject" href="{{ route('projet.destroy', $projet->id) }}">
                                <img src="{{asset("images/deleteButton.png")}}" alt="quit project button" title="Quit project" class="img-btn"/>
                            </button>
                        </form>
                        {{--<a class="btn quitproject" href="{{ route('projet.destroy', $projet->id) }}">--}}
                            {{--<img src="{{asset("images/deleteButton.png")}}" alt="quit project button" title="Quit project" class="img-btn"/>--}}
                        {{--</a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h2>Create a new project</h2>
        form here
        <a href="{{ route('projet.create')}}" class="btn btn-lg btn-primary btn-block">Create a new project</a>


        <h1>Recent Projects</h1>

        <table class="projects table table-inverse table-condensed">
            <thead>
            <tr>
                <th>Project name</th>
                <th>Collaborators</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($otherProjects as $projet)
                <tr>
                    <td class="first-cell">
                        <a href="{{ route('projet.show',$projet->id) }}">
                            <strong>{{ $projet->nom }}</strong>
                        </a>
                    </td>
                    <td>
                        @foreach ($projet->users as $user)
                            {{ $user->name }}
                            @if (! $loop->last)
                                -
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection