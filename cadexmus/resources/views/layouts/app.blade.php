<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js')}}"></script>
</head>
<body>

<div id="app">
        <header class="column column-left">
            <div>
                <h1>Cadexmus2</h1>
                <hr>
                <button id="toggle_nav" class="btn">Projets</button>
            </div>
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
                <h3>Ajouter un collaborateur</h3>
                @yield('invite')
            </div>
        </header>
        <main class="column column-center">
            <div id="container">

                <div class="projecthead">
                    <h1>Projet Yolo</h1>
                    <div style="clear:both"></div>
                </div>
                <p>
                    <span class="btnPausePlay" style="cursor:pointer"><img alt="play" src="{{asset('images/playButton.png')}}"/></span><span class="btnPausePlay" style="cursor:pointer;display:none"><img alt="play" src="{{asset('images/pauseButton.png')}}"/></span>
                    <span id="btnZoom" style="cursor:pointer"><img alt="zoom" src="{{asset('images/zoomButton.png')}}" /></span>
                    <span id="btnLock" style="cursor:pointer"><img alt="lock" src="{{asset('images/lockCloseButton.png')}}" /></span>
                </p>
                <div id="box">
                    <div>
                        @yield('content')
                    </div>
                </div>
            </div>
            <p id="debug"></p>
            <span id="toggle_chat">close chat</span>
        </main>
        <aside class="column column-right">
            <div id="chatDisplayMessages">
            </div>
            <div id="chatWriteMessage">
                <hr>
                <form style="margin:0 10px">
                    <input class="form-control" type="text" placeholder="message">
                </form>
            </div>
        </aside>
        <script>
            noms = ["fouine","chameau","blaireau"];
            couleurs = ["var(--u1)","var(--u2)","var(--u3)"];
            var element = document.getElementById("chatDisplayMessages");
            for(var i=0;i<30;i++){
                element.innerHTML+='<div class="chatMessage" style=border-color:'+couleurs[i%3]+'><p class="sender">'+noms[i%3]+'</p><p class="message">'+("coucou "+i)+'</p></div>';
                element.scrollTop = element.scrollHeight;
            }
        </script>

        <!-- Modal -->
        <div id="myModal" class="modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <p id="texteModal"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
