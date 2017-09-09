@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    @include('menus.userarea')
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">Mis Logros</div>

                        <cimerologrossummary :logros="{{ $logros }}" @if(!empty($addedCimas)) :addedcimas="{{ $addedCimas }}" @endif>
                        </cimerologrossummary>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
