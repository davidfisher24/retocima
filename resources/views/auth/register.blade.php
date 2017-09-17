@extends('layouts.app')

@section('content')
<div class="container" id="vuepage">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required autofocus>

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('apellido1') ? ' has-error' : '' }}">
                            <label for="apellido1" class="col-md-4 control-label">Apellido 1</label>

                            <div class="col-md-6">
                                <input id="apellido1" type="text" class="form-control" name="apellido1" value="{{ old('apellido1') }}" required autofocus>

                                @if ($errors->has('apellido1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apellido1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('apellido2') ? ' has-error' : '' }}">
                            <label for="apellido2" class="col-md-4 control-label">Apellido 2</label>

                            <div class="col-md-6">
                                <input id="apellido2" type="text" class="form-control" name="apellido2" value="{{ old('apellido2') }}" autofocus>

                                @if ($errors->has('apellido2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apellido2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('fechanacimiento') ? ' has-error' : '' }}">
                            <label for="fechanacimiento" class="col-md-4 control-label">Fecha Nacimiento</label>

                            <div class="col-md-6">
                                <input id="fechanacimiento" type="date" class="form-control" name="fechanacimiento" value="{{ old('fechanacimiento') }}" autofocus>

                                @if ($errors->has('fechanacimiento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fechanacimiento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pais" class="col-md-4 control-label">Pais</label>

                            <div class="col-md-6">
                                <select id="pais" class="form-control" name="pais" required>
                                    @foreach ($paises as $pais)
                                        <option value="{{$pais->id}}" 
                                            @if (($pais->id === $spain && count($errors) < 1) || ($pais->id === $spain && old('pais') === (string) $spain)) {{"selected"}} 
                                            @elseif ((int) old('pais') === $pais->id) {{"selected"}}
                                            @endif
                                        >
                                            {{$pais->nombre}}
                                        </option>
                                    @endforeach

                                </select>

                                @if ($errors->has('provincia'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('provincia') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="provincia" class="col-md-4 control-label">Provincia</label>

                            <div class="col-md-6">
                                <select id="provincia" class="form-control" name="provincia" required 
                                    @if (count($errors) >= 1 && old('pais') !== (string) $spain)
                                        {{"disabled"}}
                                    @endif
                                >
                                        <option disabled @if (count($errors) < 1) {{"selected"}}  @endif>Escoger Provincia</option>
                                    @foreach ($provincias as $provincia)
                                        <option value="{{$provincia->id}}" 
                                            @if (count($errors) >= 1 && $provincia->id == old('provincia')) {{"selected"}} @endif
                                        >
                                            {{$provincia->nombre}}
                                        </option>
                                    @endforeach

                                </select>

                                @if ($errors->has('provincia'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('provincia') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Usuario</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electronico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    window.onload = function(){
        // Record id of Spain for referencing countries
        var spainId = {{$spain}};

        // Set minimum and maximum times based on todays date
        var date = new Date();
        var startDate = (date.getFullYear() - 13) + "-" + ('0' + date.getMonth()).slice(-2) + "-" + ('0' + date.getDate()).slice(-2);
        var endDate = (date.getFullYear() - 100) + "-" + ('0' + date.getMonth()).slice(-2) + "-" + ('0' + date.getDate()).slice(-2);

        console.log(date.getDay());
        console.log(startDate);
        console.log(endDate);

        $('#fechanacimiento').attr('max',startDate);
        $('#fechanacimiento').attr('min',endDate);

        // Control the behaviour of the provincia input
        $('#pais').on('change',function(){
            $('#provincia').attr('disabled',(spainId === Number(event.target.value)) ? false : true);
        }); 
    }
    
</script>
