{{--
    Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
    This file is distributed under the MIT licence. For more
    information, please refer to the accompanying "LICENCE" file.
--}}

@extends('layouts.app')

@section('title', 'Register')

@section('body')
    <h1>Register</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        @if (session('status'))
            <p><strong>{{ $status }}</strong></p>
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
            <label for="name">{{ __('Name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus />
        </div>

        <div>
            <label for="email">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required />
        </div>

        <div>
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required />
        </div>

        <div>
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required />
        </div>

        <input type="submit" value="{{ __('Register') }}">
    </form>
    <p><a href="{{ route('login') }}">Already have an account?</a></p>
@endsection
