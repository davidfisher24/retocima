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


    <body>
        <div id="home-page">

            <nav class="navbar navbar-default navbar-static-top">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{URL::asset('./img/logocima2.png')}}" width="40" height="40">
                </a>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1 class="m-t-0 m-b-0">Reto Cima</h1>

                </a>

                @if (Route::has('login'))
                    <div class="top-right links link-effect-underline">
                        @if (Auth::check())
                            <a href="{{ url('/dashboard') }}">MI CUENTA</a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                CERRAR SESION
                            </a>

                        @else
                            <a href="{{ url('/login') }}">ENTRAR</a>
                            <a href="{{ url('/register') }}">DAR SE ALTA</a>
                        @endif
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @endif
            </nav>

            <div class="content" id="home-page-content">

                <h2 class="text-left">&nbsp;&nbsp;CERTIFICADO IBÉRICO DE MONTAÑAS ASCENDIDAS</h2>


                <div class="banner-image">
                    <img src="{{URL::asset('./img/cima.jpg')}}"   />
                </div>

                <div class="links link-effect-underline">
                    <a href="{{ url('/listadocommunidads') }}">Listado</a>
                    <a href="{{ url('/ranking') }}">Ranking</a>
                    <a href="{{ url('/patanegra') }}">Pata Negra</a>
                    <a href="{{ url('/estadistica') }}">Estadistica</a>
                    <a href="{{ url('/mapa') }}">Mapa</a>
                </div>

                <div class="container-fluid">
                    <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3 col-xl-3 col-lg-3">
                        <h4><strong>Descubrir Cimas</strong></h4>
                        <?php
                            $cima1 = null;
                            $cima2 = null;
                            $setCimas = 0;

                            while ($setCimas < 2) {
                              $cima = App\Cima::find(rand(0,App\Cima::count()));  
                              if ($cima->estado === 1 && $cima->vertientes->count() > 0) {
                                if ($setCimas < 1) {
                                    $cima1 = $cima;
                                    $setCimas++;
                                }
                                else if ($setCimas === 1 && $cima->id !== $cima1->id) {
                                    $cima2 = $cima;
                                    $setCimas++;
                                }
                              }  
                            };
                        ?>

                        <div class="panel panel-secondary" style="border:0.5px solid #ddd;border-radius:5px">
                            <div class="panel-title">
                                {{$cima1->codigo}} {{$cima1->nombre}}
                            </div>
                            <div class="panel-body">
                                <p>
                                    <img src="{{URL::asset('./img/communidads/' . $cima1->communidad_id . '.png')}}" height="24" width="32">&nbsp;
                                    {{$cima1->communidad}} - {{$cima1->provincia}}
                                </p>
                                <p>Rating APM: {{$cima1->vertientes->first()->apm}}</p>
                                <p>Acensiones: {{App\Logro::where('cima_id',$cima1->id)->count()}}</p>
                            </div>
                            <a href="{{URL::to('/')}}/detallescima/{{$cima1->id}}">Ver</a>
                        </div>

                        <div class="panel panel-secondary" style="border:0.5px solid #ddd;border-radius:5px">
                            <div class="panel-title">
                                {{$cima2->codigo}} {{$cima2->nombre}}
                            </div>
                            <div class="panel-body">
                                <p>
                                    <img src="{{URL::asset('./img/communidads/' . $cima2->communidad_id . '.png')}}" height="24" width="32">&nbsp;
                                    {{$cima2->communidad}} - {{$cima2->provincia}}
                                </p>
                                <p>Rating APM: {{$cima2->vertientes->first()->apm}}</p>
                                <p>Acensiones: {{App\Logro::where('cima_id',$cima2->id)->count()}}</p>
                            </div>
                            <a href="{{URL::to('/')}}/detallescima/{{$cima2->id}}">Ver</a>
                        </div>
                        
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-xl-6 col-lg-6">
                        <h2>¿Qué es el C.I.M.A.?</h2>
                        <p>El CIMA puede considerarse como un reto personal de carácter lúdico y no competitivo, para todos aquellos amantes del cicloturismo que deseen disfrutar ascendiendo los puertos más representativos de cada provincia española, así como Andorra y Portugal.</p>
                        <p>Todas estas cumbres han sido debatidas y seleccionadas por representantes de las diferentes regiones de nuestra geografía para, tras varios años de ardua labor y discusión en el foro de www.altimetrias.com, consensuar una lista de 640 ascensiones en las que se busca no sólo dureza, también belleza e historia, dentro de las posibilidades orográficas de cada región.</p>
                        <p>Descubre, pues, los principales puertos de montaña ibéricos, y lánzate a alcanzar el máximo número de ascensiones</p>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-3 col-xl-3 col-lg-3">
                        <a href="http://www.altimetrias.net/" target="blank">
                            <img src="{{URL::asset('./img/APM1.png')}}" width="80%" height="auto">
                        </a>
                        <br>
                        <br>
                        <a href="http://www.ziklo.es/la-revista/" target="blank">
                            <img src="{{URL::asset('./img/ziklo.jpg')}}" width="80%" height="auto">
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
