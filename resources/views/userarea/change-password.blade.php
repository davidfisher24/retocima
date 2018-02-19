@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <<div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 col-xl-3">
            @include('menus.userarea')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-9 col-lg-9 col-xl-9">
            <div class="panel panel-default">
                <div class="panel-heading">Cambiar Contraseña</div>
                <div class="panel-body">
                @if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
                <form action="" method="post" role="form" class="form-horizontal">
                    {{csrf_field()}}
 
                        <div class="form-group{{ $errors->has('old') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contrseña Actual</label>
 
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="old">
 
                                @if ($errors->has('old'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
 
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Nueva contraseña</label>
 
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
 
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
 
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirmar nueva contraseña</label>
 
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
 
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary form-control">Cambiar</button>
                                </div>
                        </div>
                </form>
                </div>
 
            </div>
        </div>
    </div>
</div>
@endsection
 
@section('scripts')
 
@endsection