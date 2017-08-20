@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Mis Logros</div>


                <div class="panel-body">
                    <a href="{{ url('/dashboard')  }}">Dashboard</a>&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/cimerocuenta')  }}">Mi Cuenta</a>&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/anadirlogros')  }}">Añadir Logros</a>&nbsp;&nbsp;&nbsp;
                </div>

                <div class="panel-body">
                    @if(!empty($addedCimas))
                        NUEVO !!
                        @foreach ($addedCimas as $addedCima)
                            <p><strong> {{ $addedCima->nombre }}  -  {{ $addedCima->provincia }}  - {{ $addedCima->communidad }} </strong></p>
                        @endforeach
                    @endif

                    @foreach ($logros as $logro)
                        <p> {{ $logro->nombre }}  -  {{ $logro->provincia }}  - {{ $logro->communidad }} </p>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
