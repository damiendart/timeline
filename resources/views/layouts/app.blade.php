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
                <ul class="site-header__navigation-list">
                    @auth
                        <li class="site-header__navigation-list__item"><a href="{{ route('events.create') }}">{{ __('Add an event') }}</a></li>
                        <li class="dropdown site-header__navigation-list__item">
                            <span class="dropdown__heading">{{ auth()->user()->name }}</span>
                            <ul class="dropdown__menu" role="menu">
                                <li class="dropdown__menu__item"><a href="#">View Profile</a></li>
                                <li class="dropdown__menu__item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <input type="submit" value="{{ __('Logout') }}">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                    @guest
                        <li class="site-header__navigation-list__item"><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li class="site-header__navigation-list__item"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @endguest
                </ul>
            </div>
            <hr class="site-header__rule">
        </header>

        @yield('body')

        <script src="{{ asset('assets/app.js') }}" async defer></script>
    </body>
</html>
