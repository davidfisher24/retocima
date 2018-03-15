<template> 
    
    <div class="panel-body">
    <loadingcontainer v-if="loading"></loadingcontainer>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12" v-if="!loading">
            <div class="row">
                <div v-for="communidad in communidads">
                    <div class="panel-group">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    {{communidad.nombre}}
                                    <a data-toggle="collapse" :href="communidad.href">  
                                        <span class="small">   Ver</span>
                                    </a>
                                </h4>
                            </div>
                            <div :id="communidad.divid"class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div v-for="logro in logros">
                                        <a v-if="logro.communidad_id === communidad.id" @click="openCimaInNewWindow(logro.id)">
                                            {{logro.cima.codigo}} - {{logro.cima.nombre}} 
                                            <span v-if="addedCimas.indexOf(logro.cima.id) !== -1">
                                                <strong>{{logro.cima.codigo}} - {{logro.cima.nombre}}  NUEVO!!</strong>
                                            </span>
                                            <span v-else-if="addedCimas.indexOf(logro.cima.id) === -1">
                                                {{logro.cima.codigo}} - {{logro.cima.nombre}} 
                                            </span>
                                        </a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        props: ["logros"],
        data: function() {
            return {
                communidads: [],
                cimas: [],
                //logros: null,
                loading: true,
                addedCimas: [],
            };
        },
        
        beforeMount: function(){
            this.addedCimas = this.$parent.addedCimas ? this.$parent.addedCimas : [];
        },

        mounted: function() {
        },

        watch: {
            logros: function(){
                this.findDistinctCommunidads();
                this.loading = false;
            },  
        },

        methods: {


            /**
             * Gets the unique communidads from the logros
             * @trigger onMounted()
             * @params references the passed logros reference
             * @result builds an array of distinct communidads
            */

            findDistinctCommunidads:function(){
                var uniqueCheck = {};
                var distinctCommunidads = [];

                this.logros.forEach(function (logro) {
                  if (!uniqueCheck[logro.communidad_id]) {
                    distinctCommunidads.push(
                        {
                            id: logro.communidad_id,
                            divid: 'collapse' + logro.communidad_id, 
                            href: '#collapse' + logro.communidad_id,
                            nombre: logro.communidad.nombre
                        }
                    );
                    uniqueCheck[logro.communidad_id] = true;
                  }
                });

                this.communidads = distinctCommunidads;
            },


            /**
             * Opens a cima details in a new window
             * @trigger onClick() of a cima link
             * @params integer cimaId
             * @result opens a new window with the detalles cima page
            */


            openCimaInNewWindow: function(cimaId){
                window.open("./detallescima/" + cimaId);
            },

        }
    }
</script>
