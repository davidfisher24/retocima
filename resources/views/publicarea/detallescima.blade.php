@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cima</div>

                <div class="panel-body">
                    <h5>{{$cima->communidad}} --> {{$cima->provincia}}</h5>
                    <h4>{{$cima->codigo}} {{$cima->nombre}}</h4>

                    @foreach ($cima->vertientes as $vertiente)
                    <div class="panel panel-default">
                        <div class="panel-heading">Vertiente: <strong>{{$vertiente->vertiente}}</strong></div>
                        <div class="panel-body">
                            <table>
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
                        </div>
                    </div>
                    @endforeach

                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection


