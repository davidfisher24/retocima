@extends('layouts.app')

@section('content')

<div class="container" id="vuepage">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 col-xl-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Cambiar Provincia
                </div>
                <div class="panel-body">
                    @foreach ($commList as $comm)
                        <div class="dropdown"> 
                            <p>{{$comm->nombre}}</p>
                            <div class="dropdown-content">
                            <ul style="list-style:none;">
                                @foreach($comm->provincias as $provincia)
                                    <li>
                                        <a href="{{URL::to('/')}}/listadoprovincias/{{$comm->id}}/{{$provincia->id}}">{{ $provincia->nombre }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-9 col-sm-9 col-xs-9 col-lg-9 col-xl-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p>
                        <img src="{{URL::asset('./img/communidads/' . $currentCommunidad . '.png')}}" height="24" width="32">&nbsp;
                        {{$commList->where('id',$currentCommunidad)->first()->nombre}} : 
                        {{$provList->where('provincia_id',$currentProvincia)->first()->provincia->nombre}}
                    </p>
                </div>
                <!--<div class="panel-heading">
                    <p class="panel-title text-center">
                        <img src="{{URL::asset('./img/communidads/' . $commList->where('id',$currentCommunidad)->first()->id . '.png')}}" height="32" width="48">
                        &nbsp;
                        {{$commList->where('id',$currentCommunidad)->first()->nombre}} : 
                        {{$provList->where('provincia_id',$currentProvincia)->first()->provincia->nombre}}
                    </p>
                </div>-->
                <div class="panel-body">
                    <!--<div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 col-xl-3">
                        @foreach ($commList as $communidad)
                            @if ($communidad->id === $currentCommunidad)
                                <p class="bg-success">
                                    <img src="{{URL::asset('./img/communidads/' . $communidad->id . '.png')}}" height="16" width="24">
                                    <strong>{{ $communidad->nombre }}</strong>
                                </p>
                            @else
                                <p>
                                    <img src="{{URL::asset('./img/communidads/' . $communidad->id . '.png')}}" height="16" width="24">
                                    <a href="{{URL::to('/')}}/listadoprovincias/{{$communidad->id}}">{{ $communidad->nombre }}</a>
                                </p>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 col-xl-3">
                    @foreach ($provList as $list)
                        @if ($list->provincia_id === $currentProvincia)
                            <p class="bg-success"><strong>{{ $list->provincia->nombre }} ({{$list->total}})</strong></p>
                        @else
                            <p>
                                <a href="{{URL::to('/')}}/listadoprovincias/{{$currentCommunidad}}/{{$list->provincia_id}}">
                                    {{ $list->provincia->nombre }} ({{$list->total}})
                                </a>   
                            </p>
                        @endif
                    @endforeach
                    </div>-->
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
                        <table class="table table-striped">
                            <thead>
                                <td>Cdg.</td>
                                <td>Nombre</td>
                                <td>Altitud</td>
                                <td>Vertientes</td>
                            </thead>
                            @foreach ($cimaList as $cima)
                                @if ($cima->estado === 1)
                                <tr>
                                    <td>{{$cima->codigo}}</td>
                                    
                                    <td>
                                        <a href="{{URL::to('/')}}/detallescima/{{$cima->id}}">
                                        {{$cima->nombre}}
                                        </a>
                                    </td>
                                    
                                    <td>{{$cima->vertientes->first()["altitud"]}}m</td>
                                    <td>
                                        @foreach ($cima->vertientes as $vertiente)
                                            {{$vertiente["vertiente"]}}<br>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </table>

                        <table class="table table-striped">
                            <thead>
                                <td colspan="4">Cimas que fueron eliminados</td>
                            </thead>
                            @foreach ($cimaList as $cima)
                                @if ($cima->estado === 2 || $cima->estado === 3)
                                <tr>
                                    <td>{{$cima->codigo}}</td>
                                    
                                    <td>
                                        {{$cima->nombre}}
                                        </a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
