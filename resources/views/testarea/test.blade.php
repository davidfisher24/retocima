@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">Test</div>

                <div class="panel-body">
                    Hello World
                </div>
                
                <div class="panel-body" id="chart_1_div" style="padding:1px;">
                    <?= $lava->render('ColumnChart', 'chart', 'chart_1_div') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="vuepage" style="display:none;">
</div>
@endsection
