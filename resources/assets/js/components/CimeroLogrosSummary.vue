<template> 
    <v-layout>
        <v-flex class="px-5">
        <loadingcontainer v-if="loading"></loadingcontainer>
        <v-expansion-panel v-for="communidad in communidads" :key="communidad.id" v-if="!loading" >
            <v-expansion-panel-content>
              <div slot="header">{{communidad.nombre}}</div>
              <v-card>
                <v-card-text v-for="logro in logros" :key="logros.id" v-if="logro.communidad_id === communidad.id">
                        {{logro.cima.codigo}} - {{logro.cima.nombre}} 
                        <span v-if="addedCimas.indexOf(logro.cima.id) !== -1">
                            <strong> NUEVO!!</strong>
                        </span>
                </v-card-text>
              </v-card>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-flex>
</v-layout>


</template>



<script>

    export default {
        props: ["logros","addedCimas"],
        data: function() {
            return {
                communidads: [],
                cimas: [],
                loading: true,
                dialog: false,
            };
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
