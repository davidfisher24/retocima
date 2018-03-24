<template> 
  <v-container fluid>
    <v-layout>
        <v-flex md12>
          <v-toolbar>
              <v-toolbar-title>
                  PATA NEGRA
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-toolbar-items>
                <v-btn flat color="info" @click="section = 'list'">Listado</v-btn>
                <v-btn flat color="info" @click="section = 'map'">Mapa</v-btn>
                <v-btn flat color="info" @click="section = 'ranking'">Ranking</v-btn>
              </v-toolbar-items>
            </v-toolbar>
       </v-flex>
      </v-layout>
      <v-layout>
         <v-flex md12 v-if="section == 'list'">
            <table class="table table-striped">
                <thead>
                    <td>Cdg.</td>
                    <td>Nombre</td>
                    <td>Logros</td>
                    <td>Altitud</td>
                </thead>
                  <tbody>
                    <tr v-for="cima in cimas" v-if="cima.estado == 1">
                        <td><p>{{cima.codigo}}</p></td>
                        <td><p>{{cima.nombre}}</p></td>
                        <td><p>{{cima.logros_count}}</p></td>
                        <td><p>{{cima.vertientes[0].altitud}} m</p></td>
                    </tr>
                  </tbody>
            </table>
         </v-flex>
        </v-layout>
        <CimaMap v-if="section == 'map'" :cimas="cimas" :center="{lat:40.416775, lng:-3.703790}" :zoom="6"></CimaMap>
        <PataNegraRanking v-if="section == 'ranking'"></PataNegraRanking>
</v-container>
</template>

<script>

    import CimaMap from '../components/Maps/CimaMap';
    import PataNegraRanking from '../components/Tables/PataNegraRanking';

    export default {
        components: {
            'CimaMap' : CimaMap,
            'PataNegraRanking' : PataNegraRanking,
        },

        data: function() {
            return {
                cimas: [],
                section: 'list',
            };
        },

        mounted: function(){
          var self = this;
          axios.get(this.baseUrl + '/api/patanegra').then(function(response){
              self.cimas = response.data;
          });
        },

        methods: {

        },
    }

</script>
