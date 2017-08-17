@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Mi Cuenta</div>


                <div class="panel-body">
                    <a href="{{ url('/dashboard')  }}">Dashboard</a>&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/cimerologros')  }}">Mis Logros</a>&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/anadirlogros')  }}">Añadir Logros</a>&nbsp;&nbsp;&nbsp;
                </div>

                <div class="panel-body">

                    <p>Nombre:   {{$cimero->nombre}} {{$cimero->apellido1}}  {{$cimero->apellido2}} </p>
                    <p>Usuario:   {{$cimero->username}} </p>
                    <p>Correo Electronico:   {{$cimero->email}} </p>
                    <p>Direccion:   {{$cimero->direccion}}, {{$cimero->poblacion}}, {{$cimero->codigopostal}}, {{$cimero->provincia}}   </p>
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
@endsection
