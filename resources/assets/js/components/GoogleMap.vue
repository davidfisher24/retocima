<template> 
    <div id="wrapper">
        <gmap-map
          :center="mapCenter"
          :zoom="6"
          map-type-id="terrain"
          style="width: 800px; height: 600px;"
        >
             <gmap-cluster :max-zoom="10" :grid-size="25">

                <gmap-marker
                  :key="index"
                  v-for="(cima, index) in filteredCimas"
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
</template>

<script>
    export default {
        props: ["cimas"],
        data: function() {
            return {
                mapCenter: {lat:40.416775, lng:-3.703790},
                selectedProvince: null,
                infoWindow: {
                    open:false,
                    template: '',
                    position: {lat:0,lng:0}
                }
            };
        },

        beforeMount: function() {
            this.baseCimas = JSON.parse(this.cimas);
            this.filteredCimas = JSON.parse(this.cimas);
        },

        methods: {

            openInfoWindowTemplate:function(item) {
                this.infoWindow.position = {lat:parseFloat(item.longitude), lng:parseFloat(item.latitude)};
                this.infoWindow.template = "<p><strong>" + item.codigo +"</strong>" + item.nombre +"</p>";
                this.infoWindow.open = true;
            }

        },

        

    }

</script>
