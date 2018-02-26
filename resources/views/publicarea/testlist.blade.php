@extends('layouts.app')

@section('content')


<div class="container" id="vuepage">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="list panel-heading">Listado</div>
                
            </div>
            <div class="list"><cimaselectionlist communidads="{{$communidads}}"></cimaselectionlist></div>

        </div>

    </div>
</div>

<script>

</script>
@endsection
