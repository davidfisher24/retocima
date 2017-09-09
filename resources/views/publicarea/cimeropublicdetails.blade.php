@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- Personal details -->
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <span>Cimero No. {{$cimero->id}}</span>
                    <div class="panel-title ">
                        <strong>{{$cimero->nombre}} {{$cimero->apellido1}} {{$cimero->apellido2}}</strong> 
                    </div>
                </div>
            </div>
            <!-- Communidads complete -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="panel-title">CCAA Completadas</p>
                </div>
                <div class="panel-body">
                    @if (count($completions["communidads"]) === 0)
                        <p>Ninguno todavia</p>
                    @else
                        @foreach ($completions["communidads"] as $communidad)
                            <p>{{$communidad->nombre}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- Communidads complete -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="panel-title">Provincias Completadas</p>
                </div>
                <div class="panel-body">
                    @if (count($completions["provincias"]) === 0)
                        <p>Ninguno todavia</p>
                    @else
                        @foreach ($completions["provincias"] as $provinceGroup)
                            @foreach ($provinceGroup as $provincia)
                                <p>{{$provincia->nombre}}</p>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                        $provKeys = array_keys($completions["provincias"]->toArray());
                        $commKeys = array_column($completions["communidads"],'id');
                    ?>
                    @foreach ($logros as $commKey => $commGroup)
                        <div class="panel-group">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <p class="panel-title">
                                        <strong>{{App\Communidad::find($commKey)->nombre}}</strong> -- 
                                        {{count($commGroup->first())}} Cimas
                                        <a data-toggle="collapse" class="pull-right" href="#{{App\Communidad::find($commKey)->id}}">  
                                            <span class="small">Ver</span>
                                        </a>
                                    </p>
                                </div>
                                <div id="{{App\Communidad::find($commKey)->id}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        @foreach ($commGroup as $provGroup)
                                            @foreach ($provGroup as $logro)
                                                <!--<div>@if (!in_array($logro->communidad_id,$commKeys) && !in_array($logro->provincia_id,$provKeys))</div>-->
                                                    <a href="{{URL::to('/')}}/detallescima/{{$logro->cima_id}}">{{$logro->cima_codigo}}</a>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach





                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
