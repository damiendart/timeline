{{--
    Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
    This file is distributed under the MIT licence. For more
    information, please refer to the accompanying "LICENCE" file.
--}}

@extends('layouts.app')

@section('title', 'Register')

@section('body')
    <h1>Logout</h1>
    <form method="POST" action="{{ route('logout') }}">
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

        <input type="submit" value="{{ __('Logout') }}">
    </form>
@endsection
