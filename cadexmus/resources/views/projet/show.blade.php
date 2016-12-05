@extends('layouts.app')

@section('content')


    <header class="column column-left">
        <button id="toggle_nav" class="btn">Projets</button>
        <nav class="hideable">
            <h3>Mes projets</h3>
            <ul class="nav  nav-stacked" >
                <li class="active"><a href="">Projet Yolo</a></li>
                <li><a href="">Les hommes crabes</a></li>
                <li><a href="">René la taupe remix</a></li>
                <li><a href="">DJ Pépé</a></li>
                <li><a href="">Schnitzel mit pommes</a></li>
                <li><a href="">Renaud 2.0</a></li>
            </ul>
            <button class="btn btn-primary">Créer un projet</button>
        </nav>

        <div>
            <hr>
            <h3>Inviter un collaborateur</h3>
            <form style="margin: 0 10px 0 0">
                <input type="text"  class="form-control" placeholder="pseudo du collaborateur">
            </form>
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
        <div id="chatDisplayMessages">
            messages ici
        </div>
        <div id="chatWriteMessage">
            <hr>
            <form style="margin:0 10px">
                <input class="form-control" type="text" placeholder="message">
            </form>
        </div>
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
                if($("header > nav").hasClass("hideable")){
                    $("header > nav").removeClass("hideable");
                }else{
                    $("header > nav").addClass("hideable");
                }
            });
        });
    </script>

@endsection