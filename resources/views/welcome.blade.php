<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Reto Cima') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="image-bg">
        <div class="flex-center position-ref full-height" id="home-page">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content" id="home-page-content">
                <div class="title">
                    Reto Cima
                </div>

                <div class="links">
                    <a href="{{ url('/listadocommunidads') }}">Listado</a>
                    <a href="{{ url('/ranking') }}">Ranking</a>
                    <a href="{{ url('/patanegra') }}">Pata Negra</a>
                    <a href="{{ url('/estadistica') }}">Estadistica</a>
                    <a href="{{ url('/mapa') }}">Mapa</a>
            </div>
        </div>
    </body>
</html>
