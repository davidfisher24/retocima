<template> 
<v-app>
   <v-container fluid>
        <loadingcontainer v-if="!cima"></loadingcontainer>
        <v-layout row wrap v-if="cima">
            <v-flex xs12 class="mx-3">
              <CimaDetail 
                class="item" 
                :cima="cima" 
                :carousel="false" 
                :back="false"
                :quickAdd="true"
              ></CimaDetail>
            </v-flex>
        </v-layout>
    </v-container>
</v-app>

</template>


<script>

    import CimaDetail from '../components/Cima/CimaDetail';

    export default {
        props: ["id"],
        data: function() {
            return {
                cima: null,
            };
        },

        components: {
            'CimaDetail' : CimaDetail,
        },

        mounted:function(){
            var self = this;
            axios.get(this.baseUrl + '/api/cima/'+this.id).then(function(response){
                response.data.communidad = response.data.communidad.nombre;
                response.data.provincia = response.data.provincia.nombre;
                self.cima = response.data;
            });
        },


    }

</script>
