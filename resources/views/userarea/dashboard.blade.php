@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12" id="vuepage">
            <dashboard :cimero="{{$cimero}}"></dashboard>
        </div>
    </div>
</div>


@endsection
