@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">anadir Logros</div>


                <div class="panel-body">
                    <a href="{{ url('/dashboard')  }}">Dashboard</a>&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/cimerocuenta')  }}">Mi Cuenta</a>&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/cimerologros')  }}">Mis Logros</a>&nbsp;&nbsp;&nbsp;
                </div>

                <div class="panel-body">
                    @foreach ($cimas as $cima)

                        @if(in_array($cima->id, $userLogros))
                            <p><strong> {{ $cima->provincia }} -- {{ $cima->nombre }} (: Ya lo tienes :) </strong></p>
                        @else
                            <p>{{ $cima->provincia }} -- {{ $cima->nombre }}</p>
                        @endif
                    @endforeach
                    
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
