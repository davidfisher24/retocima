@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Listado</div>

                <div class="panel-body">
                    @foreach ($cimaList as $cima)
                        <p>{{ $cima->communidad }}   {{$cima->total}}</p>
        
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
