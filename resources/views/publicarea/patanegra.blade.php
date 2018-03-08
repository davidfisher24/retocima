@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<p>
                		<span class="panel-title">Pata Negras</span>
                		<a href="#" class="pull-right" id="change-section">Var Ranking y Estadistica</a>
                	</p>        
                </div>

                <div class="panel-body">
                	<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6">
                        <div style="width: 100%; height: 100%;">
                            {!! Mapper::render() !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6">
                    	<table class="table table-striped">
                            <thead>
                                <td>Cdg.</td>
                                <td>Nombre</td>
                                <td>Altitud</td>
                                <td>Vertientes</td>
                            </thead>
                            @foreach ($cimas as $cima)
                                @if ($cima->estado === 1)
                                <tr>
                                    <td>{{$cima->codigo}}</td>
                                    
                                    <td>
                                        <a href="{{URL::to('/')}}/detallescima/{{$cima->id}}" target="_BLANK">
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
                    </div>
                </div>

                <div id="vuepage" style="display:none">
	            </div>

            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">

    window.onload = function(){

    }

</script>

