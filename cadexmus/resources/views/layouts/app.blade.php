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
    <link href="{{asset('src/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js')}}"></script>

    <!-- Libraries -->
    <script src="{{asset('src/jquery-ui.js')}}"></script>
    <script src="{{asset('src/jquery.ui.touch-punch.js')}}"></script>
</head>
<body>
<div id="app">
    <nav class="top-navbar">
            <div>
                <!-- Branding Image -->
                <a href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @else
                            @yield('profile_picture')
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Logout ({{Auth::user()->name}})
                                <div id="usernamelogged" style="display: none;"">{{Auth::user()->name}}</div>
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                    @endif
            </div>
    </nav>
    <div class="content">
        @yield('content')
    </div>

</div>

</body>
</html>