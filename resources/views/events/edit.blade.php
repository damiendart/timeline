{{--
    Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
    This file is distributed under the MIT licence. For more
    information, please refer to the accompanying "LICENCE" file.
--}}

@extends('layouts.app')

@section('title', __('Edit Event'))

@section('body')
    <h1>Edit event</h1>
    <form method="POST" action="{{ route('events.update', ['event' => $event]) }}">
        {{ method_field('PATCH') }}
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
            <label for="title">{{ __('Title') }}</label>
            <input id="title" type="text" name="title" value="{{ old('title', $event->title) }}" required autofocus />
        </div>

        <div>
            <label for="slug">{{ __('Slug') }}</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug', $event->slug) }}" required />
        </div>

        <div>
            <label for="email">{{ __('Date') }}</label>
            <input id="date" type="date" name="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" required />
        </div>

        <div>
            <label for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description">{{ old('description', $event->description) }}</textarea>
        </div>

        <input type="submit" value="{{ __('Update') }}">
    </form>
    <form method="POST" action="{{ route('events.destroy', ['event' => $event]) }}">
        {{ method_field('DELETE') }}
        @csrf

        <input type="submit" value="{{ __('Delete') }}">
    </form>
@endsection
