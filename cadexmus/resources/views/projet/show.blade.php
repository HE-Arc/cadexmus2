@extends('layouts.app')

@section('content')

    <header class="column column-left">
        <button id="toggle_nav" class="btn">Projets</button>

        <nav class="hideable" id="nav-projects">
            <span><img src="{{asset('images/ajax-loader.gif')}}" alt="loading"></span>
        </nav>

        <div>
            <hr>
            @include('projet.invite')
        </div>
    </header>

    <main class="column column-center">
        <div id="container">
            @include('projet.edit')
        </div>
        <p id="debug"></p>
        <span id="toggle_chat">close chat</span>
    </main>

    <aside class="column column-right">
            @include('chat.index')
    </aside>

    <script>
        $(document).ready(function(){
            $("#toggle_chat").click(function(){
                if($(this).html()=="close chat"){
                    $(this).html("open chat");
                    $(".column-right").hide();
                }else{
                    $(this).html("close chat");
                    $(".column-right").show();
                }
            });

            $("#toggle_nav").click(function(){
                $("header > nav").toggleClass("hideable");
            });

            $.get("{{ route('projet.index') }}").done(function(data){
                $("#nav-projects").html(data);
                $("#projet_{{$projet->id}}").addClass('active');
            });
        });
    </script>

@endsection