@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Listado</div>

                <div class="panel-body">
                    @foreach ($cimeros as $cimero)
                        <p>{{ $cimero->nombre }} {{ $cimero->apellido1 }} {{ $cimero->apellido2 }} -- {{$cimero->logros_count}}</p>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
