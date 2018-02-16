@extends('layouts.app')

@section('content')
<div class="container" id="vuepage">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3">
                            <table class="table">
                                <tr>
                                    <td><strong>GPS:</strong>
                                </tr>
                                <tr>
                                    <td>Longitude: </td>
                                    <td>{{$cima->longitude}}</td>
                                </tr>
                                <tr>
                                    <td>Latitude: </td>
                                    <td>{{$cima->latitude}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6">
                             <h2 class="text-center">{{$cima->codigo}} {{$cima->nombre}}</h2>
                             <h5 class="text-center">{{$cima->communidad}} --> {{$cima->provincia}}</h5>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 col-xl-3">
                            @if ($userLogro)
                                <div><h3>Logro Completed!</h3></div>
                            @else
                                <div>
                                    <button class="btn btn-primary">Añadir Logro</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    @foreach ($cima->vertientes as $vertiente)
                    <div class="panel panel-default">
                        <div class="text-center"><h4>Vertiente: <strong>{{$vertiente->vertiente}}</strong><h4></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4 col-xl-4">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>Altitud: </td><td><strong>{{$vertiente->altitud}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Desnivel: </td><td><strong>{{$vertiente->desnivel}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Longitud: </td><td><strong>{{$vertiente->longitud}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>% medio: </td><td><strong>{{$vertiente->porcentage_medio}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>% máx.: </td><td><strong>{{$vertiente->porcentage_maximo}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>APM: </td><td><strong>{{$vertiente->apm}}</strong></td>
                                        </tr>
                                    </table>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="text-center">Altimetrias</td>
                                        </tr>
                                        @if(count($vertiente->enlaces) === 0)
                                            <tr>
                                                <td class="text-center">
                                                    <p><strong>No Disponible!</strong></p>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($vertiente->enlaces as $index => $enlace)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{$enlace->url}}" target="_blank">
                                                        Enlace {{$index + 1}}
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8 col-lg-8 col-xl-8 text-center">
                                    <iframe src="{{$vertiente->iframe}}" style="width:500px;height:400px">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <p><strong>Inicio: </strong>{{$vertiente->inicio}}</p>
                            <p><strong>Dudas:  </strong>{{$vertiente->dudas}}</p>
                            <p><strong>Final:  </strong>{{$vertiente->final}}</p>
                            <p><strong>Observaciones: </strong>{{$vertiente->observaciones}}</p>
                        </div>
                    </div>
                    @endforeach

                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection


