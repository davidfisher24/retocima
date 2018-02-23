@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">Mapa de Cimas</div>

                <!--div class="panel-body" id="vuepage">
                <googlemap cimas="{{$cimas}}"></googlemap>-->
                    <!--LARAVEL ELEMENT -->
                    <div class="col-md-8 col-sm-8 col-xs-8 col-lg-8 col-xl-8">
                        <div style="width: auto; height: 500px;">
                            {!! Mapper::render() !!}
                        </div>
                        
                    </div>
                    <div id="vuepage" style="display:none;"></div>
                    <div id="mappanel" class="col-md-4 col-sm-4 col-xs-4 col-lg-4 col-xl-4">
                        <mapcontainer :cima="cima"></mapcontainer>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    var vueInstance;

    function mouseClickCima(cima)
    {

        if (vueInstance) {
            vueInstance.cima = cima;
        } else {
            vueInstance = new window.Vue({
                data: function() {
                    return {
                        cima: cima,
                    };
                },

                el: '#mappanel',

            });

            vueInstance.cima = cima;
        }

        

    }
</script>
