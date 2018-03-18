<template> 
    <v-layout>
        <v-flex class="px-5">
        <loadingcontainer v-if="loading"></loadingcontainer>
        <v-expansion-panel v-for="communidad in communidads" :key="communidad.id" v-if="!loading" >
            <v-expansion-panel-content>
              <div slot="header">{{communidad.nombre}}</div>
                <v-layout row>
                  <v-flex sm6 xs6>
                  <v-list v-for="(chunk,index) in chunkedLogros(communidad.id)" :key="index">
                    <v-list-tile-content v-for="logro in chunk" :key="logro.id" class="py-1 px-1">
                            {{logro.cima.codigo}} - {{logro.cima.nombre}} 
                            <span v-if="addedCimas.indexOf(logro.cima.id) !== -1">
                                <strong> NUEVO!!</strong>
                            </span>
                    </v-list-tile-content>
                  </v-list>
                  </v-flex>
                </v-layout>
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

        computed: {
           
        },

        watch: {
            logros: function(){
                this.findDistinctCommunidads();
                this.loading = false;
            },  
        },

        methods: {
            chunkedLogros:function (communidadId) {
                var result = this.logros.filter(l => l.communidad_id === communidadId)
                return _.chunk(result,result.length/2);
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
