<style>
    button.x-small {
        height:25px !important;
        width:25px !important;
    }
</style>

<template> 
    <v-container  fluid>

        <loadingcontainer v-if="loading"></loadingcontainer>
        <ProvinciaSelection v-show="!loading && !province && !cimas" @mounted="loading = false" @chosen="showProvince"></ProvinciaSelection>
        <v-layout v-if="cimas && province && !loading" row wrap>
          <v-flex md12 xs12 sm12 >
            <v-toolbar>
                <v-toolbar-title>
                    <Flag :id="province[0].communidad_id"></Flag>
                    {{province[0].communidad}} - {{province[0].provincia}}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat color="info" @click="cimas = null, province = null">Atras</v-btn>
                </v-toolbar-items>
              </v-toolbar>
              <v-card>
                <v-list>

                  <v-list-tile avatar v-for="item in incompleteCimas" :key="item.id">
                    <v-list-tile-avatar>
                      {{ item.codigo }}
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                      <v-list-tile-title>{{ item.nombre }}</v-list-tile-title>
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-btn fab dark small color="indigo" class="x-small" 
                        v-if="adding.indexOf(item.id) === -1 && added.indexOf(item.id) === -1"
                        @click="add(item.id)"
                    >+</v-btn>
                      <v-btn fab dark small color="indigo" class="x-small" loading v-if="adding.indexOf(item.id) !== -1"></v-btn>
                    </v-list-tile-action>
                  </v-list-tile>
                  <v-divider inset></v-divider>

                  <v-expansion-panel>
                    <v-expansion-panel-content>
                      <div slot="header">Cimas Completadas - {{completeCimas.length}} logros</div>
                        <v-list-tile avatar v-for="item in completeCimas" :key="item.id">
                            <v-list-tile-avatar>
                              {{ item.codigo }}
                            </v-list-tile-avatar>
                            <v-list-tile-content>
                              <v-list-tile-title>{{ item.nombre }}</v-list-tile-title>
                            </v-list-tile-content>
                            <v-list-tile-action>
                              <v-btn fab dark small color="cyan" class="x-small"  
                                v-if="adding.indexOf(item.id) === -1 && added.indexOf(item.id) === -1"
                                @click="remove(item.id)"
                              >-</v-btn>
                              <v-btn fab dark small color="indigo" class="x-small" loading v-if="adding.indexOf(item.id) !== -1"></v-btn>

                            </v-list-tile-action>
                          </v-list-tile>
                    </v-expansion-panel-content>
                  </v-expansion-panel>


                   
                </v-list>
              </v-card>


          </v-flex>
        </v-layout>
    </v-container>

</template>

<script>

    import ProvinciaSelection from '../components/ProvinciaSelection'; 

    export default {
        components: {
          'ProvinciaSelection' : ProvinciaSelection,
        },

        data: function() {
            return {
                loading: true,
                cimas: null,
                province: null,
                adding: [],
                added: [],
            };
        },

        computed: {
           completeCimas:function(){
                var logroIds = _.map(this.cimas, 'cima_id');
                return this.province.filter(function(p){
                    return logroIds.indexOf(p.id) !== -1;
                });
           },
           incompleteCimas:function(){
                var logroIds = _.map(this.cimas, 'cima_id');
                return this.province.filter(function(p){
                    return logroIds.indexOf(p.id) === -1;
                });
           },
        },
        
        methods: {

            showProvince: function(id){
                var self = this;
                this.loading = true;
                var logros = axios.get(this.baseUrl + '/ajax/userprovincialogros/' + id);
                var provincia = axios.get(this.baseUrl + '/api/cimas/' + id)
                Promise.all([logros,provincia]).then(function(response){
                    self.cimas = response[0].data;
                    self.province = response[1].data;
                    self.loading = false;
                });
            },

            add: function(id){
                this.adding.push(id);
                var self = this;
                axios.post(this.baseUrl + '/ajax/update-logro',{
                    action: 'add',
                    cima: id,
                }).then(function(response){
                    if (response.data) {
                        self.cimas.push(response.data);
                        self.adding.splice(self.adding.indexOf(id),1);
                    }
                });
            },

            remove: function(id){
                this.adding.push(id);
                var logro = this.cimas.find(x => x.cima_id === id);
                var self = this;
                axios.post(this.baseUrl + '/ajax/update-logro',{
                    action: 'remove',
                    logro: JSON.stringify(logro),
                }).then(function(response){
                    if (!response.data) {
                        self.adding.splice(self.adding.indexOf(id),1);
                        var index = 0;
                        self.cimas.forEach(function(x, i){
                          if (x.cima_id === id) index = i;
                        });
                        self.cimas.splice(index,1);
                    }
                });
            },
        }
    }
</script>
