@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$cimero->id}}  {{$cimero->nombre}} {{$cimero->apellido1}} {{$cimero->apellido2}}</div>

                <div class="panel-body">
                    @foreach ($logros as $commKey => $commGroup)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{App\Communidad::find($commKey)->nombre}}
                            </div>
                            <div class="panel-body">
                        @foreach ($commGroup as $provGroup)
                            
                            @foreach ($provGroup as $logro)
                                {{$logro->cima_codigo}}
                            @endforeach
                            
                        @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
