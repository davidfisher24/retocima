<style>
    .badge{
        background: transparent;
    }
</style>

<template> 
<v-app>
  <homepagecarousel></homepagecarousel>
    <v-container >
        <v-layout>
          CERTIFICADO IBÉRICO DE MONTAÑAS ASCENDIDAS
        </v-layout>
                 
        <v-layout>
            <v-flex md3>
              <v-card v-if="discoverCimas" v-for="cima in discoverCimas" :key="cima.id">
                <v-card-title primary-title>
                  <div>
                    <h3 class="headline mb-0">{{cima.codigo}} {{cima.nombre}}</h3>
                    {{cima.communidad}} - {{cima.provincia}}<br>
                    Acensiones: {{cima.logros_count}}
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn flat color="blue">Ver</v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
            <v-flex md6>
              <h2>¿Qué es el C.I.M.A.?</h2>
              <p>El CIMA puede considerarse como un reto personal de carácter lúdico y no competitivo, para todos aquellos amantes del cicloturismo que deseen disfrutar ascendiendo los puertos más representativos de cada provincia española, así como Andorra y Portugal.</p>
              <p>Todas estas cumbres han sido debatidas y seleccionadas por representantes de las diferentes regiones de nuestra geografía para, tras varios años de ardua labor y discusión en el foro de www.altimetrias.com, consensuar una lista de 640 ascensiones en las que se busca no sólo dureza, también belleza e historia, dentro de las posibilidades orográficas de cada región.</p>
              <p>Descubre, pues, los principales puertos de montaña ibéricos, y lánzate a alcanzar el máximo número de ascensiones</p>
            </v-flex>
            <v-flex md3>
              <a href="http://www.altimetrias.net/" target="blank">
                  <img :src="image('img/APM1.png')" width="80%" height="auto">
              </a>
              <br>
              <br>
              <a href="http://www.ziklo.es/la-revista/" target="blank">
                  <img :src="image('img/ziklo.jpg')" width="80%" height="auto">
              </a>
            </v-flex>
        </v-layout>
    </v-container>
</v-app>


</template>


<script>

  

    export default {
        components: {
  
        },

        data: function() {
            return {
              discoverCimas:null,
            };
        },

        computed: {

        },


        beforeMount:function(){
        },

        mounted:function(){
          var self = this;
          axios.get(self.baseUrl + '/ajax/discover').then(function(response){
            self.discoverCimas = response.data;
            console.log(self.discoverCimas);
          });
        },

        methods: {
          image: function(link){
            return this.baseUrl + link;
          }
      
        },

        watch: {

        },

    }

</script>
