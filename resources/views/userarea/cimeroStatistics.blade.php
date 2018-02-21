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
                        <div class="carousel slide" data-ride="carousel" data-interval="false" id="statisticsCarousel">
                          <div class="carousel-inner">
                            <div class="item active">
                                <div id="hc" class="panel"></div>
                            </div>
                            <div class="item">
                              <div id="hc2" class="panel"></div>
                            </div>
                            <div class="item">
                              <div id="hc3" class="panel"></div>
                            </div>
                          </div>
                          <a class="left pull-left" href="#statisticsCarousel" data-slide="prev">
                            ANTERIOR
                          </a>
                          <a class="right pull-right" href="#statisticsCarousel" data-slide="next">
                            SIGUIENTE
                          </a>
                        </div>
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
        window.HighCharts.chart('hc2', 
            <?php echo json_encode($chartarray[1]) ?>
        ); 
        window.HighCharts.chart('hc3', 
            <?php echo json_encode($chartarray[2]) ?>
        );
    }

</script>
@endsection

