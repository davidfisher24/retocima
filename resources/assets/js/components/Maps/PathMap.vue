<template> 
    <div id="wrapper">
        <gmap-map
          v-if="coords && mounted"
          :center="getPathMapCenter()"
          :zoom="11"
          map-type-id="terrain"
          :style="style"
        >
            <gmap-polyline v-if="path" 
            :path="path" 
            :options="{strokeColor: '#0000FF'}"/>
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
            var hEst = Math.max(document.documentElement.clientHeight, window.innerHeight || 0) - document.getElementById('wrapper').parentElement.getBoundingClientRect().y;
            var w = document.getElementById('wrapper').parentElement.offsetWidth;
            var h = document.getElementById('wrapper').parentElement.offsetHeight < 1 ? document.getElementById('wrapper').parentElement.offsetHeight : hEst;
            this.style = "width: "+w+"px; height: "+h+"px; margin:0;";
            self.mounted = true;
            this.getMapLines();  
        },

        methods: {
            getMapLines: function(){
                var self=this;
                axios.get(this.baseUrl + '/maplines/'+self.id + '.txt').then(function(response){
                    var coords = [];
                    response.data.data.forEach(function(d) {
                        coords.push({lat: d[0][0], lng: d[0][1]})
                    });
                    self.coords = coords;
                    self.putLine();
                });
            },

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

        watch: { 
            id: function(newVal, oldVal) { // watch it
                this.coords = null;
                this.path = [];
                this.getMapLines();
            }
        }
    }

</script>
