@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    @include('menus.userarea')
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">Mi Cuenta</div>

                        <div class="panel-body">
                            <p>Nombre:   {{$cimero->fullName}} </p>
                            <p>Usuario:   {{$cimero->username}} </p>
                            <p>Correo Electronico:   {{$cimero->email}} </p>
                            <p>Direccion:   {{$cimero->fullAddress}}  </p>
                            <p>puertofavorito:   {{$cimero->puertofavorito}}</p>
                            <p>puertomasduro:   {{$cimero->puertomasduro}}</p>
                            <p>puertomasfacil:   {{$cimero->puertomasfacil}}</p>
                            <p>bicicleta:   {{$cimero->bicicleta}}</p>
                            <p>desarrollo:   {{$cimero->desarrollo}}</p>
                            <p>grupo:   {{$cimero->grupo}}</p>
                            <p>frase:   {{$cimero->frase}}</p>
                            <p>nickmiarroba:   {{$cimero->nickmiarroba}}</p>
                            <p>web:   {{$cimero->web}}</p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
