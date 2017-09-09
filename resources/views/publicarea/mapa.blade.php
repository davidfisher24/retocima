@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Mapa de Cimas</div>

                <div class="panel-body">
                    <div class="col-md-8">
                        <div style="width: 700px; height: 600px;">
                            {!! Mapper::render() !!}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function mouseClickCima(cima)
    {
        console.log(cima);
    }

</script>
@endsection
