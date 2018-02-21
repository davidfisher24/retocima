@extends('layouts.app')

@section('content')


<div class="container" id="vuepage">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">Listado</div>


                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                            @for ($i = 0; $i < count($communidads) /2; $i ++)
                                <div class="dropdown">
                                    <p>
                                        <img src="{{URL::asset('./img/communidads/' . $communidads[$i]->id . '.png')}}" height="24" width="32">&nbsp;
                                        <a href="#" href="{{URL::to('/')}}/listadoprovincias/{{$communidads[$i]->id}}">{{ $communidads[$i]->nombre }}</a>
                                        ({{count($communidads[$i]->cimas)}})
                                    </p>
                                    <div class="dropdown-content">
                                        <ul style="list-style:none;">
                                            @foreach($communidads[$i]->provincias as $provincia)
                                                <li>
                                                    <a href="{{URL::to('/')}}/listadoprovincias/{{$communidads[$i]->id}}/{{$provincia->id}}">{{ $provincia->nombre }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 left">
                            @for ($i = count($communidads) /2; $i < count($communidads); $i ++)
                                <div class="dropdown">
                                    <p>
                                        <img src="{{URL::asset('./img/communidads/' . $communidads[$i]->id . '.png')}}" height="24" width="32">&nbsp;
                                        <a href="#" href="{{URL::to('/')}}/listadoprovincias/{{$communidads[$i]->id}}" >{{ $communidads[$i]->nombre }}</a>
                                        ({{count($communidads[$i]->cimas)}})
                                    </p>
                                    <div class="dropdown-content">
                                        <ul style="list-style:none;">
                                            @foreach($communidads[$i]->provincias as $provincia)
                                                <li>
                                                    <a href="{{URL::to('/')}}/listadoprovincias/{{$communidads[$i]->id}}/{{$provincia->id}}">{{ $provincia->nombre }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                
            </div>
            <!--<cimaselectionlist communidads="{{$communidads}}"></cimaselectionlist>-->
            <!--<cimasearch cimas="{{$cimas}}"></cimasearch>-->
        </div>

    </div>
</div>
@endsection
