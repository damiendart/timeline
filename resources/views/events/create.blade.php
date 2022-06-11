@extends('layouts.app')

@section('title', __('Add an event'))

@section('body')
    <h1>Add an event</h1>
    <form method="POST" action="{{ route('events.store') }}">
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
            <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus />
        </div>

        <div>
            <label for="slug">{{ __('Slug') }}</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug') }}" required />
        </div>

        <div>
            <label for="email">{{ __('Date') }}</label>
            <input id="date" type="date" name="date" value="{{ old('date') }}" required />
        </div>

        <div>
            <label for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <input type="submit" value="{{ __('Update') }}">
    </form>
@endsection
