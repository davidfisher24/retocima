@extends('layouts.app')

@section('content')
<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    @include('menus.userarea')
                </div>
                <div class="col-md-9" id="vuepage">
                    <div class="panel panel-default">
                        <div class="panel-heading">Mi Cuenta</div>

                        <div class="panel-body">
                            <cimeroeditcuentaform cimeromodel="{{$cimero}}" provincias="{{$provincias}}" paises="{{$paises}}"></cimeroeditcuentaform>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
