@extends('layouts.app')

@section('title', 'Login')

@section('body')
    <h1>Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if (session('status'))
            <p><strong>{{ session('status') }}</strong></p>
        @endif

        @if ($errors->any())
            <strong>{{ __('Whoops! Something went wrong.') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div>
            <label for="email">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />
        </div>

        <div>
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" />
        </div>

        <div>
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember"> {{ __('Remember me') }}
            </label>
        </div>

        <input type="submit" value="{{ __('Log in') }}">
    </form>
    <p><a href="{{ route('register') }}">Create an account</a></p>
@endsection
