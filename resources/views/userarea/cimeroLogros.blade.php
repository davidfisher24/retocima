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

                <cimerologrossummary :logros="{{ $logros }}" @if(!empty($addedCimas)) :addedcimas="{{ $addedCimas }}" @endif>
                </cimerologrossummary>


            </div>
        </div>
    </div>
</div>
@endsection
