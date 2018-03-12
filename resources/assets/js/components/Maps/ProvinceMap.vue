<template> 
    <div id="wrapper">
        <gmap-map
          v-if="mounted"
          :center="getMapCenter()"
          :zoom="getMapZoom()"
          map-type-id="terrain"
          :style="style"
        >
             <gmap-cluster :max-zoom="10" :grid-size="25">

                <gmap-marker
                  :key="index"
                  v-for="(cima, index) in cimas"
                  :position="{lng:parseFloat(cima.latitude), lat:parseFloat(cima.longitude)}"
                  :clickable="true"
                  :draggable="false"
                  @click="showCima(cima.id)"
                ></gmap-marker>

            </gmap-cluster>
        </gmap-map>
    </div>
</template>

<script>
    export default {
        props: ["cimas"],
        data: function() {
            return {
                mounted: false,
                style: "",
            };
        },

        mounted:function() {
            var hEst = Math.max(document.documentElement.clientHeight, window.innerHeight || 0) - document.getElementById('wrapper').parentElement.getBoundingClientRect().y; 
            var w = document.getElementById('wrapper').parentElement.offsetWidth;
            var h = document.getElementById('wrapper').parentElement.offsetHeight < 1 ? document.getElementById('wrapper').parentElement.offsetHeight : hEst;
            this.style = "width: "+w+"px; height: "+h+"px; margin:0;";
            this.mounted = true;
        },

        methods: {
            getMapCenter: function(){
                var lats = this.getLats();
                var lngs = this.getLngs();
                var latSum = lats.reduce(function(a, b) { return a + b; });
                var lngSum = lngs.reduce(function(a, b) { return a + b; });
                return {lat: lngSum / lngs.length, lng: latSum / lats.length};
            },

            getMapZoom: function(){
                var lats = this.getLats();
                var lngs = this.getLngs();
                var latDiff = Math.abs(Math.max.apply(null,lats) - Math.min.apply(null,lats));
                var lngDiff = Math.abs(Math.max.apply(null,lngs) - Math.min.apply(null,lngs));
                var maxDiff = Math.max(latDiff,lngDiff);
                return parseInt(11 - maxDiff);
                 
            },

            getLats: function(){
                return this.cimas.map(function(a){ return parseFloat(a.latitude) }).filter(function(b) { return b !== 0});
            },

            getLngs: function(){
                return this.cimas.map(function(a){ return parseFloat(a.longitude) }).filter(function(b) { return b !== 0});
            },
        },
    }

</script>
