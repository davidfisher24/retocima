<template> 
    <div>
        <gmap-map
          v-if="coords"
          :center="getPathMapCenter()"
          :zoom="12"
          map-type-id="terrain"
          style="width: 500px; height: 400px;"
        >
            <gmap-polyline v-if="path" :path="path" />
        </gmap-map>
        <a @click="drawLine()">ROUTE</a>
    </div>
</template>

<script>
    export default {
        props: ["id"],
        data: function() {
            return {
                coords: null,
                path: [],
                drawing: null,
                drawIndex: 0,
            };
        },

        mounted:function() {
            var self=this;
            axios.get(this.baseUrl + '/maplines/'+self.id + '.txt').then(function(response){
                var coords = [];
                response.data.data.forEach(function(d) {
                    coords.push({lat: d[0][0], lng: d[0][1]})
                });
                self.coords = coords;
            });
        },

        methods: {
            getPathMapCenter: function(){
                var maxLat = this.coords.map(function(row){ return Math.max.apply(Math, row); });
                var minLat = this.coords.map(function(row){ return Math.min.apply(Math, row); });
                var maxLng = this.coords.map(function(row){ return Math.max.apply(Math, row); });
                var minLng = this.coords.map(function(row){ return Math.min.apply(Math, row); });
                var half = Math.round(this.coords.length / 2);
                return this.coords[half];
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
