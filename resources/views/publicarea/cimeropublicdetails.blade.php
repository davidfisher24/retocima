@extends('layouts.app')

@section('content')
<?php
    $completedProvinceIds = array_map(function($province) {
      return $province['id'];
    }, $completedProvinces);

    $completedCommunidadIds = array_map(function($communidad) {
      return $communidad['id'];
    }, $completedCommunidads);

?>

<div class="container" id="vuepage">
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
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
                    @if (count($completedCommunidads) === 0)
                        <p>Ninguno todavia</p>
                    @else
                        @foreach ($completedCommunidads as $communidad)
                            <p>{{$communidad->nombre}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- Provinces complete -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="panel-title">Provincias Completadas</p>
                </div>
                <div class="panel-body">
                    @if (count($completedProvinces) === 0)
                        <p>Ninguno todavia</p>
                    @else
                        @foreach ($completedProvinces as $province)
                            @if (!in_array($province->communidad_id,$completedCommunidadIds))
                                <p>{{$province->nombre}}</p>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <div class="panel panel-default">
                <div class="panel-body">

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
                                @if (in_array($commGroup->first()->first()->communidad_id, $completedCommunidadIds))
                                    <div id="{{App\Communidad::find($commKey)->id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <span><strong>COMMUNIDAD COMPLETADO</strong></span>
                                        </div>
                                    </div>
                                @else
                                    <div id="{{App\Communidad::find($commKey)->id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            @foreach ($commGroup as $provGroup)
                                                <?php $indexes = array() ?>
                                                @foreach ($provGroup as $index => $logro)
                                                    @if(!in_array($logro->provincia_id,$completedProvinceIds))
                                                        <a href="{{URL::to('/')}}/detallescima/{{$logro->cima_id}}">{{$logro->cima_codigo}}</a>
                                                    @elseif (!in_array($logro->provincia_id,$indexes))
                                                        <span><strong>{{App\Provincia::find($logro->provincia_id)->nombre}} COMPLETED</strong></span>
                                                        <?php array_push($indexes,$logro->provincia_id); ?>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Test Graphics -->
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="panel-title">Logros Por Provincia</p>
                </div>
                <div class="panel-body" id="chart_1_div" style="padding:1px;">
                    <?= $lava->render('PieChart', 'chart_1', 'chart_1_div') ?>
                </div>
            </div>  
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="panel-title">Donde estoy en cada communidad</p>
                </div>
                <div class="panel-body" id="chart_2_div" style="padding:1px;">
                    <?= $lava->render('ColumnChart', 'chart_2', 'chart_2_div') ?>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection
