<template> 
    <div class="panel-body">
        <div class="col-md-12">
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
                                    <div v-for="addedcima in addedcimas">
                                        <p v-if="addedcima.communidad_id === communidad.id" class="text-primary">
                                            {{addedcima.codigo}} - {{addedcima.nombre}}  NUEVO!!
                                        </p> 
                                    </div>
                                    <div v-for="logro in logros">
                                        <p v-if="logro.communidad_id === communidad.id">
                                            {{logro.codigo}} - {{logro.nombre}}
                                        </p> 
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
        data: function() {
            return {
                communidads: [],
                cimas: [],
            };
        },
        props: ['logros','addedcimas'],

        mounted: function() {
            this.findDistinctCommunidads();
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
                            nombre: logro.communidad
                        }
                    );
                    uniqueCheck[logro.communidad_id] = true;
                  }
                });

                this.communidads = distinctCommunidads;
            }

        }
    }
</script>
