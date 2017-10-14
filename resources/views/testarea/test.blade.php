@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">Test</div>
                <div id="hc" class="panel"></div>
                <div id="hc2" class="panel"></div>
                <div id="hc3" class="panel"></div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="vuepage" style="display:none;">
</div>
@endsection

<script type="text/javascript">

    window.onload = function(){

        window.HighCharts.chart('hc', 
            <?php echo json_encode($chartarray[0]) ?>
        ); 

        window.HighCharts.chart('hc2', 
            <?php echo json_encode($chartarray[1]) ?>
        ); 

        var chart3 = <?php echo json_encode($chartarray[2]) ?>;
        chart3.series[1].tooltip.pointFormatter = function () {
            return '<b>' + Math.round((this.y * 50)) + ' </b>Ascensiones en total';
        };
        console.log(chart3);
        window.HighCharts.chart('hc3', 
            chart3
        ); 




    }

</script>