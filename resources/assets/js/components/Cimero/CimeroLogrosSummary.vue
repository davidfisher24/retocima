<template> 
    <v-layout>
        <v-flex class="px-3">
            <loadingcontainer v-if="loading"></loadingcontainer>
            <v-expansion-panel v-for="communidad in communidads" :key="communidad.id" v-if="!loading" focusable>
                <v-expansion-panel-content >
                    <div slot="header" >{{communidad.nombre}}
                        <v-badge color="primary">
                            <span slot="badge" v-html="countLogros(communidad.id)"></span>
                        </v-badge>
                    </div>
                    <v-container>
                        <v-layout row wrap>
                            <v-flex xs12 md6 v-for="(chunk,index) in chunkedLogros(communidad.id)" :key="index">
                                <v-list >
                                    <v-list-tile-content v-for="logro in chunk" :key="logro.id" class="px-1 py-1" >
                                        {{logro.cima.codigo}} - {{logro.cima.nombre}}
                                    </v-list-tile-content>
                                </v-list>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-flex>
    </v-layout>
</template>



<script>

    export default {
        props: ["userLogros"],
        data: function() {
            return {
                communidads: [],
                cimas: [],
                loading: true,
                dialog: false,
                logros: null,
            };
        },

        mounted: function() {
            var self = this;
            if (this.userLogros) {
                this.logros = this.userLogros;
                this.findDistinctCommunidads();
                this.loading = false;
                return;
            }
            axios.get(this.baseUrl + '/ajax/userfulllogros').then(function(response){
               self.logros = response.data;
               self.findDistinctCommunidads();
               self.loading = false;
            });
        },

        computed: {
           
        },

        watch: {
            logros: function(){
                this.findDistinctCommunidads();
            },  
        },

        methods: {
            chunkedLogros:function (communidadId) {
                var result = this.logros.filter(l => l.communidad_id === communidadId);
                return _.chunk(result,Math.ceil(result.length/2));
           },

           countLogros: function(communidadId){
                return this.logros.filter(l => l.communidad_id === communidadId).length;
           },

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
