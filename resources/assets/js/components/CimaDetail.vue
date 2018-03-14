<template> 
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="panel panel-default"  v-if="cima.vertientes" v-for="vertiente in cima.vertientes">
                        <div class="text-center"><h4>Vertiente: <strong>{{vertiente.vertiente}}</strong></h4></div>
                        <div class="panel-body">
                            <cimaquickadd v-if="renderQuickAdd" :cima="cima" :logro="userLogro"></cimaquickadd>
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4 col-xl-4 fake-table">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>Altitud:</strong></p></div>
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{vertiente.altitud}}</p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>Desnivel:</strong></p></div>
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{vertiente.desnivel}}</p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>Longitud:</strong></p></div>
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{vertiente.longitud}}</p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>% medio:</strong></p></div>
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{vertiente.porcentage_medio}}</p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>% máx.:</strong></p></div>
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{vertiente.porcentage_maximo}}</p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>APM:</strong></p></div>
                                        <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{vertiente.apm}}</p></div>
                                    </div>
                                    <div class="row row-delimiter">
                                        <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12 col-sm-12"><p><strong>ENLACES</strong></p></div>

                                    </div>
                                    <div class="row" v-if="vertiente.enlaces.length === 0">
                                        <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12 col-sm-12"><p>No Disponible!</p></div>
                                    </div>
                                    <div class="row row-link" v-for="(enlace,index) in vertiente.enlaces" >
                                        <a :href="enlace.url" target="_blank"><div class="col-md-12 col-xs-12 col-lg-12 col-xl-12 col-sm-12"><p>Enlace {{index + 1}}</p></div></a>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-12 col-xs-12 col-lg-8 col-xl-8 text-center google-map-column">
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
    import PathMap from './Maps/PathMap';

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

        beforeMount: function(){
        },

        mounted:function() {
            var self = this;
            axios.get(self.baseUrl + '/ajax/checklogro/'+this.cima.id).then(function(response){
                if (response.data !== 'Unauthorized') self.renderQuickAdd = true;
                self.userLogro = response.data;
            });
        },

    }

</script>
