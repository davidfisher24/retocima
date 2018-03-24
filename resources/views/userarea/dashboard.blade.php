@extends('layouts.app')

@section('content')
<div id="vuepage">
    <dashboard :cimero="{{$cimero}}"></dashboard>
</div>
@endsection
