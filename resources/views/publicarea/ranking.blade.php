@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Ranking</div>

                <div class="panel-body">
                    @foreach ($cimeros as $cimero)
                        <p><a href="{{URL::to('/')}}/cimeropublicdetails/{{$cimero->cimero_id}}">{{ $cimero->nombre }}</a> -- {{$cimero->logros_count}}</p>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
