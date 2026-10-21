<!doctype html>
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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v={{ time() }}" rel="stylesheet">

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
```html
<!doctype html>
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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v={{ time() }}" rel="stylesheet">

    <!-- Cloudflare Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js"
            async defer></script>

    <!-- Dark Theme -->
    <style>
        :root {
            color-scheme: dark;

            --bg-main: #121418;
            --bg-navbar: #1c2027;
            --bg-card: #1c2027;
            --bg-hover: #252d3a;
            --border-color: #30343b;
            --text-main: #e5e7eb;
            --text-muted: #9ca3af;
            --accent: #60a5fa;
        }

        html {
            min-height: 100%;
            background-color: var(--bg-main);
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
        }

        #app {
            min-height: 100vh;
            background-color: var(--bg-main);
        }

        /* Navbar */
        .navbar {
            background-color: var(--bg-navbar) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar .navbar-brand {
            color: var(--text-main) !important;
            font-weight: 700;
        }

        .navbar .nav-link {
            color: var(--text-muted) !important;
            transition: color 0.2s ease;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: var(--accent) !important;
        }

        /* Mobile navbar toggler */
        .navbar .navbar-toggler {
            border-color: var(--border-color);
        }

        .navbar .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.2);
        }

        .navbar .navbar-toggler-icon {
            filter: invert(1);
        }

        /* Dropdown */
        .navbar .dropdown-menu {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        }

        .navbar .dropdown-item {
            color: var(--text-main);
            padding: 10px 16px;
        }

        .navbar .dropdown-item:hover,
        .navbar .dropdown-item:focus {
            color: var(--accent);
            background-color: var(--bg-hover);
        }

        /* Main content */
        main {
            min-height: calc(100vh - 60px);
            background-color: var(--bg-main);
            color: var(--text-main);
        }

        /* Forms */
        .form-control,
        .form-select {
            background-color: #181b21;
            border-color: var(--border-color);
            color: var(--text-main);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #181b21;
            border-color: var(--accent);
            color: var(--text-main);
            box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.15);
        }

        .form-control::placeholder {
            color: #6b7280;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #252932;
            color: var(--text-muted);
        }

        .form-check-input {
            background-color: #181b21;
            border-color: #4b5563;
        }

        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        label,
        .form-label,
        .form-check-label {
            color: var(--text-main);
        }

        /* Cards */
        .card {
            background-color: var(--bg-card);
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .card-header,
        .card-footer {
            background-color: #20242c;
            border-color: var(--border-color);
        }

        /* Tables */
        .table {
            --bs-table-color: var(--text-main);
            --bs-table-bg: transparent;
            --bs-table-border-color: var(--border-color);
            --bs-table-striped-bg: #191d24;
            --bs-table-striped-color: var(--text-main);
            --bs-table-hover-bg: var(--bg-hover);
            --bs-table-hover-color: var(--text-main);

            color: var(--text-main);
            border-color: var(--border-color);
        }

        /* Links */
        a {
            color: var(--accent);
        }

        a:hover {
            color: #93c5fd;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
        }

        /* Buttons */
        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        /* Horizontal rules */
        hr {
            border-color: var(--border-color);
            opacity: 1;
        }

        /* Bootstrap muted text */
        .text-muted {
            color: var(--text-muted) !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown"
                                   class="nav-link dropdown-toggle"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false"
                                   v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end"
                                     aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item"
                                       href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form"
                                          action="{{ route('logout') }}"
                                          method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
