@extends('layouts.app')

@section('content')
<div class="container" id="vuepage">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">Entrar</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 col-xs-4 col-sm-4 col-lg-4 col-xl-4 control-label">Usuario o correo electronico</label>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6">
                                <input id="email" class="form-control" name="login" value="{{ old('login') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 col-xl-offset-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuerdame
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-sm-8 col-xs-8 col-lg-8 col-xl-8 col-xl-offset-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Entrar
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    ¿Has olvidado tu contraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
