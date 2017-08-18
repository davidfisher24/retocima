@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Listado</div>

                <div class="panel-body">
                    <div class="col-md-4 col-sm-8">
                    @foreach ($provList as $list)
                        <p>
                            @if (!empty($currentProv))
                                <a href="{{URL::to('/')}}/listadoprovincias/{{$list->provincia_id}}">
                                    {{ $list->provincia->nombre }}
                                </a>   
                                {{$list->total}}
                            @else
                                <a href="{{URL::to('/')}}/listadoprovincias/{{$list->provincia_id}}">
                                    {{ $list->provincia->nombre }}
                                </a>  
                            @endif
                        </p>
                    @endforeach
                    </div>
                    <div class="col-md-8 col-sm-8">
                    @foreach ($cimaList as $cima)
                        <p>{{$cima->nombre}}</p>
                    @endforeach
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
