@extends('layouts.app')

@section('content')

    <header class="column column-left expand-vertical">
        <button id="toggle_nav" class="btn">Projects</button>

        <div id="nav-projects" class="hideable expand-vertical">
            <div  class="expand-vertical">
                <h3><a href="{{ route('projet.index') }}">My projects</a></h3>
                <nav id="project-list" class="expand-vertical">
                    <span><img src="{{asset('images/ajax-loader.gif')}}" alt="loading"></span>
                </nav>

            </div>
        </div>

        @include('projet.invite', ['asGuest' => $asGuest])
    </header>

    <main class="column column-center">
        <div id="container">
            @include('projet.edit')
        </div>
        <span id="toggle_chat">&gt;&gt;</span>
    </main>

    <aside class="column column-right expand-vertical">
            @include('chat.index')
    </aside>

@endsection
