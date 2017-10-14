@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">Test</div>
                <div id="hc" class="panel"></div>
                <div id="hc2" class="panel"></div>
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


    }

</script>