<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('assets/app.css') }}" rel="stylesheet">
        <script>document.documentElement.className+='javascript'</script>
        <title>{{ config('app.name', 'Timeline') }} — @yield('title')</title>
    </head>
    <body>
        <header class="site-header">
            <div class="site-header__container">
                <div class="site-header__heading">
                    <a href="{{ route('home') }}">{{ config('app.name', 'Timeline') }}</a>
                </div>
            </div>
            <hr class="site-header__rule">
        </header>

        @yield('body')

        <script src="{{ asset('assets/app.js') }}" async defer></script>
    </body>
</html>
