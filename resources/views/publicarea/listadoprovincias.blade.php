@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Listado</div>

                <div class="panel-body">
                    <div class="col-md-3 col-sm-3">
                        @foreach ($commList as $communidad)
                            @if ($communidad->id === $currentCommunidad)
                                <p><strong>{{ $communidad->nombre }}</strong></p>
                            @else
                                <p><a href="{{URL::to('/')}}/listadoprovincias/{{$communidad->id}}">{{ $communidad->nombre }}</a></p>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-3 col-sm-3">
                    @foreach ($provList as $list)
                        @if ($list->provincia_id === $currentProvincia)
                            <p><strong>{{ $list->provincia->nombre }} ({{$list->total}})</strong></p>
                        @else
                            <p>
                                <a href="{{URL::to('/')}}/listadoprovincias/{{$currentCommunidad}}/{{$list->provincia_id}}">
                                    {{ $list->provincia->nombre }} ({{$list->total}})
                                </a>   
                            </p>
                        @endif
                    @endforeach
                    </div>
                    <div class="col-md-6 col-sm-6">
                    @foreach ($cimaList as $cima)
                        <p>
                            <a href="{{URL::to('/')}}/detallescima/{{$cima->id}}">
                                {{$cima->nombre}}</a>
                        </p>
                    @endforeach
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
