<template> 
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 col-xl-12" v-if="cima">
            <div class="panel panel-success">
                <div class="panel-title">
                    <p class="panel-heading text-center">
                        <strong>{{cima.codigo}} {{cima.nombre}}</strong>
                    </p>
                </div>
                <div class="panel-body" v-if="cima">
                    <p v-for="vertiente in vertientes">
                        <a href="#" @click.prevent="selectedVertiente = vertiente">{{vertiente.vertiente}}</a>
                    </p>
                </div>
                <div class="panel-body" v-if="selectedVertiente">
                    <table class="table table-striped">
                        <tr>
                            <td>Altitud: </td><td><strong>{{selectedVertiente.altitud}}</strong></td>
                        </tr>
                        <tr>
                            <td>Desnivel: </td><td><strong>{{selectedVertiente.desnivel}}</strong></td>
                        </tr>
                        <tr>
                            <td>Longitud: </td><td><strong>{{selectedVertiente.longitud}}</strong></td>
                        </tr>
                        <tr>
                            <td>% medio: </td><td><strong>{{selectedVertiente.porcentage_medio}}</strong></td>
                        </tr>
                        <tr>
                            <td>% máx.: </td><td><strong>{{selectedVertiente.porcentage_maximo}}</strong></td>
                        </tr>
                        <tr>
                            <td>APM: </td><td><strong>{{selectedVertiente.apm}}</strong></td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">
                    <a  target="_BLANK" :href="cimaPageRoute">Ver Pagina Entera</a>;
                </div>
            </div>
        </div>
    </div>
</template>




<script>
    export default {
        data: function() {
            return {
                vertientes: null,
                selectedVertiente: null,
            };
        },

        props: ['cima'] ,

        computed: {
            cimaPageRoute: function(){
                return "./detallescima/" + this.cima.id;
            },

        },

        watch: {
            cima: function(cima){
                this.vertientes = cima.vertientes;
                this.selectedVertiente = null;
            },
        },

        mounted: function() {
            this.vertientes = this.cima.vertientes;
        },

        methods: {

            showVertiente(evt) {
                evt.preventDefault();
            },

        }
    }
</script>
