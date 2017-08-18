@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Listado</div>

                <div class="panel-body">
                    @foreach ($commList as $list)
                        <p><a href="{{URL::to('/')}}/listadoprovincias/{{$list->communidad_id}}">{{ $list->communidad->nombre }}</a>   {{$list->total}}</p>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
