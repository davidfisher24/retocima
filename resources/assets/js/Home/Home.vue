<template> 
<v-app>
  <HomePageCarousel></HomePageCarousel>
    <v-container fluid>

                 
        <v-layout>
            <v-flex md3  class="text-xs-center">
              <div v-if="discoverCimas" v-for="cima in discoverCimas" :key="cima.id" class="text-xs-center">
                <v-card-title primary-title class="mx-3" >
                  <div>
                    <p class="mb-0"><Flag :id="cima.communidad_id"></Flag>{{cima.codigo}} {{cima.nombre}}</p>
                    {{cima.communidad}} - {{cima.provincia}}<br>
                    Acensiones: {{cima.logros_count}}
                    <div><v-btn flat color="blue" class="ma-0 pa-0">Ver</v-btn></div>
                  </div>
                </v-card-title>
              </div>
            </v-flex>



            <v-flex md6>
              <v-layout>
                <v-flex>
                  <h1 class="headline text-xs-center primary--text">
                  <span class="accent--text">C</span>ertificado 
                  <span class="accent--text">I</span>bérico de 
                  <span class="accent--text">M</span>ontañas 
                  <span class="accent--text">A</span>scendidas</h1>
                </v-flex>
              </v-layout>
              <h2>¿Qué es el C.I.M.A.?</h2>
              <p>El CIMA puede considerarse como un reto personal de carácter lúdico y no competitivo, para todos aquellos amantes del cicloturismo que deseen disfrutar ascendiendo los puertos más representativos de cada provincia española, así como Andorra y Portugal.</p>
              <p>Todas estas cumbres han sido debatidas y seleccionadas por representantes de las diferentes regiones de nuestra geografía para, tras varios años de ardua labor y discusión en el foro de www.altimetrias.com, consensuar una lista de 640 ascensiones en las que se busca no sólo dureza, también belleza e historia, dentro de las posibilidades orográficas de cada región.</p>
              <p>Descubre, pues, los principales puertos de montaña ibéricos, y lánzate a alcanzar el máximo número de ascensiones</p>
            </v-flex>
            <v-flex md3 class="text-xs-center">
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

    import HomePageCarousel from './HomePageCarousel';



    export default {
        components: {
          'HomePageCarousel' : HomePageCarousel,
  

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
          axios.get(this.baseUrl + '/ajax/discover').then(function(response){
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
