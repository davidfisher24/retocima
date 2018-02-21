@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    @include('menus.userarea')
                </div>
                <div class="col-md-9" id="vuepage">
                    <div class="panel panel-default">
                        <div class="panel-heading">Mis Estadisticas</div>

                        <!-- Chart -->
                        <div id="hc" class="panel"></div>
                        <!-- Map -->
                        <!--<div style="width: 700px; height: 600px;">
                            {!! Mapper::render() !!}
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    window.onload = function(){
        window.HighCharts.chart('hc', 
            <?php echo json_encode($chartarray[0]) ?>
        ); 
    }

</script>
@endsection

