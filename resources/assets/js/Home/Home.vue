<template> 
<v-app>
    <HomePageCarousel></HomePageCarousel>
    <v-container fluid>
      <v-layout row wrap>
        <v-flex xs12 md3 order-xs2 order-md1>
 
            <v-card v-if="discoverCimas" v-for="cima in discoverCimas" :key="cima.id" class="ma-2 pa-4 primary--text text-xs-center" raised >
                  <div class="title "><Flag :id="cima.communidad_id"></Flag>{{cima.codigo}} {{cima.nombre}}</div>
                  <div class="mt-2 body-2">{{cima.communidad}} - {{cima.provincia}}</div>
                  <div class="mt-1 body-2">Acensiones: {{cima.logros_count}}</div>
                  <v-btn flat color="accent" block>Ver</v-btn>
            </v-card>
        </v-flex>
        <v-flex xs12 md6 class="text-xs-center primary--text" order-xs1 order-md2>
          <p class="headline display-2">
          <span class="accent--text">C</span>ertificado 
          <span class="accent--text">I</span>bérico de 
          <span class="accent--text">M</span>ontañas 
          <span class="accent--text">A</span>scendidas</p>
          <p class="subheading">¿Qué es el C.I.M.A.?</p>
          <p class="body-2">El CIMA puede considerarse como un reto personal de carácter lúdico y no competitivo, para todos aquellos amantes del cicloturismo que deseen disfrutar ascendiendo los puertos más representativos de cada provincia española, así como Andorra y Portugal.</p>
          <p class="body-2">Todas estas cumbres han sido debatidas y seleccionadas por representantes de las diferentes regiones de nuestra geografía para, tras varios años de ardua labor y discusión en el foro de www.altimetrias.com, consensuar una lista de 640 ascensiones en las que se busca no sólo dureza, también belleza e historia, dentro de las posibilidades orográficas de cada región.</p>
          <p class="body-2">Descubre, pues, los principales puertos de montaña ibéricos, y lánzate a alcanzar el máximo número de ascensiones</p>
        </v-flex>
        <v-flex xs12 md3 class="text-xs-center" order-xs3 order-md3>
          <a href="http://www.altimetrias.net/" target="blank">
              <img :src="image('img/APM1.png')" width="80%" height="auto" max-height="30%">
          </a>
          <br>
          <br>
          <a href="http://www.ziklo.es/la-revista/" target="blank">
              <img :src="image('img/ziklo.jpg')" width="80%" height="auto" max-height="70%">
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
