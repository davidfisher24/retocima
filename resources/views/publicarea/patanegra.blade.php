@extends('layouts.app')

@section('content')
<div class="container-fluid" id="vuepage">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<p>
                		<span class="panel-title">Pata Negras</span>
                		<a href="#" class="pull-right" id="change-section">Var Ranking y Estadistica</a>
                	</p>        
                </div>
                <div class="panel-body">
                    <patanegracontainer></patanegracontainer>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">

    window.onload = function(){

    }

</script>

