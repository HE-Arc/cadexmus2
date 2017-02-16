@extends('layouts.app')

@section('content')
<div class="container">
    <form class="form-signin" role="form" method="POST" action="{{ url('/register') }}"  enctype="multipart/form-data">
        <h2>Register to Cadexmus</h2>

        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="control-label">Username</label>

            <div>
                <input id="name" type="text" class="form-control" name="name" placeholder="Username" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label">E-Mail Address</label>

            <div>
                <input id="email" type="email" class="form-control" name="email" placeholder="E-Mail Address" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="control-label">Password</label>

            <div>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="password-confirm" class="control-label">Confirm Password</label>

            <div>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
            </div>
        </div>
        <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
            <label for="picture" class="control-label">Upload a picture</label>

            <div>
                <input id="picture" type="file" class="form-control" name="picture" accept="image/*">

                @if ($errors->has('picture'))
                    <span class="help-block">
                        <strong>{{ $errors->first('picture') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <button id="registerSubmit" type="submit" class="btn btn-lg btn-primary btn-block">
                Register
            </button>
        </div>
    </form>
</div>
@endsection
