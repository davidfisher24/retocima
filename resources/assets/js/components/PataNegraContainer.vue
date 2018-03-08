<template> 
    <div id="wrapper" class="row">
      <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6">
        <gmap-map
          :center="mapCenter"
          :zoom="6"
          map-type-id="terrain"
          style="width: 100%; height: 100%"
        >
             <gmap-cluster :max-zoom="10" :grid-size="25">

                <gmap-marker
                  :key="index"
                  v-for="(cima, index) in cimas"
                  :position="{lng:parseFloat(cima.latitude), lat:parseFloat(cima.longitude)}"
                  :clickable="true"
                  :draggable="false"
                  @click="openInfoWindowTemplate(cima)"
                ></gmap-marker>

                <gmap-info-window
                    :options="{maxWidth: 300}"
                    :position="infoWindow.position"
                    :opened="infoWindow.open"
                    @closeclick="infoWindow.open=false">
                    <div v-html="infoWindow.template"></div>
                </gmap-info-window>

            </gmap-cluster>
        </gmap-map>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6">
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
      </div>
    </div>    
</template>

<script>


    export default {
     

        data: function() {
            return {
                cimas: [],
                mapCenter: {lat:40.416775, lng:-3.703790},
                infoWindow: {
                    open:false,
                    template: '',
                    position: {lat:0,lng:0}
                },
            };
        },

        mounted: function(){
          var self = this;
          axios.get('/api/patanegra').then(function(response){
              self.cimas = response.data;
          });
        },

        methods: {

            openInfoWindowTemplate:function(item) {
                this.infoWindow.position = {lat:parseFloat(item.longitude), lng:parseFloat(item.latitude)};
                this.infoWindow.template = "<p><strong>" + item.codigo +"</strong>   " + item.nombre +"</p>";
                this.infoWindow.template += "<a href='detallescima/"+item.id+"' target='_BLANK'>VER</a>";
                this.infoWindow.open = true;
            },

        },
    }

</script>
