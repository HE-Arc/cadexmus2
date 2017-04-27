@extends('layouts.app')

@section('content')
<div class="container">
    <form class="form-signin" role="form" method="POST" action="{{ url('/login') }}">
        <h2>Please sign in</h2>

        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="sr-only">Username</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Username" title="Username" required autofocus>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="sr-only">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" title="Password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">
            Sign in
        </button>

        <p></p>
        <p>
            <a href="{{ url('/password/reset') }}">
                Forgot Your Password ?
            </a>
            <br>
            New user ?
            <a href="{{ url('/register') }}">
                Register
            </a>
        </p>
        <h3>Welcome, guest user !</h3>
        <p>
        You can sign in using username: <b>demo</b>, password: <b>demo</b>
        </p>
    </form>
</div>
@endsection
