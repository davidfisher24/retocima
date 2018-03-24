<template> 
    <v-container fluid>
        <v-layout v-if="comms" row wrap>
          <v-flex md6 xs12 sm12  v-for="(chunk,index) in chunkedCommunidads" :key="index" class="px-3">
            <v-expansion-panel>
                    <v-expansion-panel-content v-for="(communidad,index) in chunk" :key="communidad.id" >
                      <div slot="header">
                           <Flag :id="communidad.id"></Flag>
                            {{communidad.nombre}}
                            <v-badge top>
                              <span slot="badge">{{communidad.cimas_count}}</span>
                            </v-badge>
                      </div>
                
                      <v-list dense>
                        <v-list-tile v-for="provincia in communidad.provincias" :key="provincia.id" @click="chooseProvince(provincia.id)">
                          <v-list-tile-title class="py-0">{{provincia.nombre}}</v-list-tile-title>
                        </v-list-tile>
                      </v-list>
                    </v-expansion-panel-content>
                </v-expansion-panel>
          </v-flex>
        </v-layout>
    </v-container>

</template>

<script>


    export default {
        components: {

        },

        data: function() {
            return {
                comms: null,
                count: null,
                mounted: false,
            };
        },

        computed: {
           chunkedCommunidads:function () {
                return _.chunk(this.comms,this.comms.length/2);
           },
        },

        watch: {
          mounted:function(){
            this.$emit('mounted',null);
          },
        },

        mounted: function() {
            var self = this;
            axios.get(this.baseUrl + '/api/communidads').then(function(response){
                self.comms = response.data;
                self.count = Object.keys(self.comms).length;
                self.mounted = true;
            });
        },

        methods: {

          chooseProvince(id){
            this.$emit('chosen',id);
          },
        }
    }
</script>
