<template> 
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                
                    <div class="row">
                        <div class="col-md-3">
                            <table class="table">
                                <tr>
                                    <td><strong>GPS:</strong></td>
                                </tr>
                                <tr>
                                    <td>Longitude: </td>
                                    <td>{{cima.longitude}}</td>
                                </tr>
                                <tr>
                                    <td>Latitude: </td>
                                    <td>{{cima.latitude}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6">
                             <h2 class="text-center">{{cima.codigo}} {{cima.nombre}}</h2>
                             <h5 class="text-center">{{cima.communidad}} --> {{cima.provincia}}</h5>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 col-xl-3">
                            <cimaquickadd v-if="renderQuickAdd" :cima="cima.id" :logro="userLogro"></cimaquickadd>
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="panel panel-default"  v-if="cima.vertientes" v-for="vertiente in cima.vertientes">
                        <div class="text-center"><h4>Vertiente: <strong>{{vertiente.vertiente}}</strong></h4></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4 col-xl-4">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>Altitud: </td><td><strong>{{vertiente.altitud}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Desnivel: </td><td><strong>{{vertiente.desnivel}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Longitud: </td><td><strong>{{vertiente.longitud}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>% medio: </td><td><strong>{{vertiente.porcentage_medio}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>% máx.: </td><td><strong>{{vertiente.porcentage_maximo}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>APM: </td><td><strong>{{vertiente.apm}}</strong></td>
                                        </tr>
                                    </table>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="text-center">Altimetrias</td>
                                        </tr>
        
                                            <tr v-if="vertiente.enlaces.length === 0">
                                                <td class="text-center">
                                                    <p><strong>No Disponible!</strong></p>
                                                </td>
                                            </tr>
                                            <tr v-if="vertiente.enlaces.length > 0">
                                                <td class="text-center">
                                                    <a v-for="(enlace,index) in vertiente.enlaces" :href="enlace.url" target="_blank">
                                                        Enlace {{index + 1}}
                                                    </a>
                                                </td>
                                            </tr>
                                    </table>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8 col-lg-8 col-xl-8 text-center">
                                    <!--<iframe :src="vertiente.iframe" style="width:500px;height:400px;max-width:100%;">
                                    </iframe>-->
                                    <PathMap :id="vertiente.id"></PathMap>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-left">
                            <p><strong>Inicio: </strong>{{vertiente.inicio}}</p>
                            <p><strong>Dudas:  </strong>{{vertiente.dudas}}</p>
                            <p><strong>Final:  </strong>{{vertiente.final}}</p>
                            <p><strong>Observaciones: </strong>{{vertiente.observaciones}}</p>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
    import PathMap from './PathMap';

    export default {
        props: ["cima"],
        components: {
            'PathMap' : PathMap,
        },
        data: function() {
            return {
                renderQuickAdd: false,
                userLogro: null,
            };
        },

        mounted:function() {
            var self = this;
            /*axios.get('/ajax/checklogro/'+this.cima.id).then(function(response){
                self.renderQuickAdd = true;
                self.userLogro = response.data;
            });;*/
        },

    }

</script>
