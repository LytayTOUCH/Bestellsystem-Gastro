<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ App\Models\SiteSettings::first()->site_name }}</title>

    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="{{ asset('storage/icons/shisha/favicon.ico') }}">
    <link rel="apple-touch-icon" type="image/png" href="{{ asset('storage/icons/shisha/icon57.png') }}"><!-- iPhone -->
    <link rel="apple-touch-icon" type="image/png" sizes="72x72" href="{{ asset('storage/icons/shisha/icon72.png') }}"><!-- iPad -->
    <link rel="apple-touch-icon" type="image/png" sizes="114x114" href="{{ asset('storage/icons/shisha/icon114.png') }}"><!-- iPhone4 -->
    <link rel="icon" type="image/png" href="{{ asset('storage/icons/shisha/icon114.png') }}"><!-- Opera Speed Dial, at least 144×114 px -->
    
    <link href="{{ asset('storage/icons/shisha/favicon.ico') }}" rel="shortcut icon" type="image/x-icon" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap_'. App\Models\SiteSettings::first()->site_template .'.min.css') }}">
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ url('/') }}">{{ App\Models\SiteSettings::first()->site_name }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Startseite</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/bestellungen') }}">Bestellungen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/verwaltung') }}">Verwaltung</a>
                </li>

                @guest
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ explode(" ", Auth::user()->name)[0] }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
            </div>
        </nav>

        @if(env('APP_ENV') == "development")
            <div class="alert alert-warning" role="alert">
              Du befindest dich auf einem Entwicklungssystem
            </div>
        @endif

        <br>

        <div class="container">
            @if(session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error_message'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('error_message') }}
                </div>
            @endif
            
            @yield('content')
            <br>
            <br>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/socket.io.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
