<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:800|Titillium+Web:300,400,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="skilltree">
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark shadow">
            <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/img/nti_logo_white.svg" height="30" alt="{{ config('app.name', 'Laravel') }}">
                    </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                               <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                             <a
                                    id="navbarDropdown"
                                    class="nav-link dropdown-toggle"
                                    href="#" role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false" v-pre
                                >
                                    @if(auth()->user()->avatar)
                                        <img
                                            src="{{ auth()->user()->avatar }}"
                                            class="rounded-circle"
                                            alt="avatar"
                                            width="32"
                                            height="32"
                                            style="margin-right: 8px;"
                                        >
                                    @endif
                                    {{ auth()->user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>

            @yield('content')

            <flash message="{{ session('flash') }}"></flash>
            <loader @onCenterLoading="status()"></loader>
            {{-- @include('skilltrees.toast') --}}
        </main>
    </div>
    @if (Request::is('skilltrees/*'))
        @include('skilltrees.dragConnect')
    @endif
</body>
</html>
