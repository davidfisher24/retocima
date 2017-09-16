@extends('layouts.app')

@section('content')
<div class="container" id="vuepage">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">Listado</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-center">
                            @for ($i = 0; $i < count($commList) /2; $i ++)
                                <p>
                                    <img src="{{URL::asset('./img/communidads/' . $commList[$i]->communidad_id . '.png')}}" height="24" width="32">
                                    &nbsp;
                                    <a href="{{URL::to('/')}}/listadoprovincias/{{$commList[$i]->communidad_id}}">{{ $commList[$i]->communidad->nombre }}</a>   ({{$commList[$i]->total}})
                                </p>
                            @endfor
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-center">
                            @for ($i = count($commList) /2; $i < count($commList); $i ++)
                                <p>                                
                                    <a href="{{URL::to('/')}}/listadoprovincias/{{$commList[$i]->communidad_id}}">{{ $commList[$i]->communidad->nombre }}</a>   ({{$commList[$i]->total}})
                                    &nbsp;
                                    <img src="{{URL::asset('./img/communidads/' . $commList[$i]->communidad_id . '.png')}}" height="24" width="32">
                                </p>
                            @endfor
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
