<template> 
    <div id="wrapper">
        <gmap-map
          v-if="coords && mounted"
          :center="getPathMapCenter()"
          :zoom="12"
          map-type-id="terrain"
          style="width: 500px; height: 400px;"
        >
            <gmap-polyline v-if="path" 
            :path="path" />
            <gmap-marker
              v-if="path"
              :position="coords[0]"
              :clickable="false"
              :draggable="false"
            ></gmap-marker>
            <gmap-marker
               v-if="path"
              :position="coords[coords.length -1]"
              :clickable="false"
              :draggable="false"
            ></gmap-marker>
        </gmap-map>
        <!--<a @click="drawLine()">ROUTE</a>-->
    </div>
</template>

<script>
    export default {
        props: ["id"],
        data: function() {
            return {
                mounted: false,
                style: "",
                coords: null,
                path: [],
                drawing: null,
                drawIndex: 0,
            };
        },

        mounted:function() {
            var self=this;
            var w = document.getElementById('wrapper').parentElement.offsetWidth;
            this.style = "width: "+w+"px; height: "+w+"px; margin:0;";
            
            axios.get(this.baseUrl + '/maplines/'+self.id + '.txt').then(function(response){
                var coords = [];
                response.data.data.forEach(function(d) {
                    coords.push({lat: d[0][0], lng: d[0][1]})
                });
                self.mounted = true;
                self.coords = coords;
                self.putLine();
            });
        },

        methods: {
            getPathMapCenter: function(){
                var lats = [], lngs = [];
                this.coords.forEach(function(coord){
                    lats.push(coord.lat); lngs.push(coord.lng);
                });
                return {
                    lat: (Math.max.apply(null,lats) + Math.min.apply(null,lats)) / 2,
                    lng: (Math.max.apply(null,lngs) + Math.min.apply(null,lngs) )/ 2,
                }
                var half = Math.round(this.coords.length / 2);
                return this.coords[half];
            },

            putLine: function(){
                this.path = this.coords;
            },

            drawLine: function(){
                var self = this;
                this.drawing = setInterval(function(){ self.draw() }, 10)
            },

            draw: function(){
                if (this.coords[this.drawIndex]) {
                    this.path.push(this.coords[this.drawIndex]);
                    this.drawIndex = this.drawIndex + 1;
                } else {
                  clearInterval(this.drawing);
                }
            },
        },
    }

</script>
