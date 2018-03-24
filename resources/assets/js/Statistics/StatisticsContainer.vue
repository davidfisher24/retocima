<template> 
<v-container fluid>
    <v-layout>
        <v-flex md12 v-if="!activeTable && !activeFilters">
            <v-card>
                <v-toolbar>
                  <v-toolbar-title>Estasistica</v-toolbar-title>
                </v-toolbar>
                <v-list>
                    <v-list-tile @click="activeTable = 'CimerosRanking', route='provinciasstarted'"><v-list-tile-content>
                        <v-list-tile-title>Cimeros por Provincias comenzados</v-list-tile-title>
                    </v-list-tile-content ></v-list-tile>
                    <v-list-tile @click="activeTable = 'CimasRanking'"><v-list-tile-content>
                        <v-list-tile-title>Las CIMAs más ascendido</v-list-tile-title>
                    </v-list-tile-content></v-list-tile>
                    <v-list-tile @click="activeTable = 'ProvinciasRanking'"><v-list-tile-content>
                        <v-list-tile-title>Las Provincias más ascendidas</v-list-tile-title>
                    </v-list-tile-content></v-list-tile>
                    <v-list-tile @click="activeTable = 'CommunidadsRanking'"><v-list-tile-content>
                        <v-list-tile-title>Las CC.AA más ascendidas</v-list-tile-title>
                    </v-list-tile-content></v-list-tile>
                    <v-list-tile @click="activeFilters = 'provincias'"><v-list-tile-content>
                        <v-list-tile-title>Ranking de cimeros por provincia</v-list-tile-title>
                    </v-list-tile-content></v-list-tile>
                    <v-list-tile @click="activeFilters = 'communidads'"><v-list-tile-content>
                        <v-list-tile-title>Ranking de cimeros por communidads</v-list-tile-title>
                    </v-list-tile-content></v-list-tile>
                </v-list>
              </v-card>
        </v-flex>
        <v-flex v-if="!activeTable && activeFilters == 'communidads'">
            <v-toolbar>
                <v-toolbar-title>
                    Selccionar Communidad
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat color="info" @click="back()">Atras</v-btn>
                </v-toolbar-items>
              </v-toolbar>
              <v-list sm12 md6 v-for="(chunk,i) in chunkedCommunidads" :key="i">
                <v-list-tile  v-for="communidad in chunk"@click="setRoute('communidad',communidad.id)" :key="communidad.id"><v-list-tile-content>
                    <v-list-tile-title>{{communidad.nombre}}</v-list-tile-title>
                </v-list-tile-content></v-list-tile>
              </v-list>
        </v-flex>
        <v-flex v-if="!activeTable && activeFilters == 'provincias'">
        <v-toolbar>
            <v-toolbar-title>
                Selccionar Provincia
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn flat color="info" @click="back()">Atras</v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-list sm6 md3 v-for="(chunk,i) in chunkedProvinces" :key="i">
            <v-list-tile  v-for="provincia in chunk" @click="setRoute('provincia',provincia.id)" :key="provincia.id"><v-list-tile-content>
                <v-list-tile-title>{{provincia.nombre}}</v-list-tile-title>
            </v-list-tile-content></v-list-tile>
          </v-list>
        </v-flex>
        <v-flex md12 v-if="activeTable">
            <v-toolbar>
                <v-toolbar-title>
                    Data
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat color="info" @click="back()">Atras</v-btn>
                </v-toolbar-items>
              </v-toolbar>
            <CimerosRanking v-if="activeTable == 'CimerosRanking'" :route="route"></CimerosRanking>
            <CimasRanking v-if="activeTable == 'CimasRanking'"></CimasRanking>
            <ProvinciasRanking v-if="activeTable == 'ProvinciasRanking'"></ProvinciasRanking>
            <CommunidadsRanking v-if="activeTable == 'CommunidadsRanking'"></CommunidadsRanking>
            <FiltersRanking v-if="activeTable == 'FiltersRanking'" :bringFilters="bringFilters"></FiltersRanking>
        </v-flex>
    </v-layout>
</v-container>
</template>



<script>
import CimerosRanking from '../components/Tables/CimerosRanking'
import CimasRanking from '../components/Tables/CimasRanking'
import ProvinciasRanking from '../components/Tables/ProvinciasRanking'
import CommunidadsRanking from '../components/Tables/CommunidadsRanking'
import FiltersRanking from '../components/Tables/FiltersRanking'
    export default {
        components: {
            'CimerosRanking' : CimerosRanking,
            'CimasRanking': CimasRanking,
            'ProvinciasRanking': ProvinciasRanking,
            'CommunidadsRanking': CommunidadsRanking,
            'FiltersRanking' : FiltersRanking,
        },  

        data: function() {
            return {
                route:null,
                activeTable: null,
                activeFilters: null,
                bringFilters:null,
                provincias: [],
                communidads: [],
            };
        },

        computed: {
           chunkedCommunidads:function () {
            return _.chunk(this.communidads,this.communidads.length/2);
           },
           chunkedProvinces:function () {
            return _.chunk(this.provincias,this.provincias.length/4);
           }
        },

        mounted: function() {
            this.fetchComunidadsAndProvinces();
        },

        methods: {
            
            fetchComunidadsAndProvinces:function(){
                var self = this;

                axios.get(this.baseUrl + '/api/communidads').then(function(response){
                    response.data.forEach(function(item){
                        item.imageurl = self.baseUrl + '/img/communidads/' + item.id + '.png';
                    });
                    self.communidads = response.data;

                });

                axios.get(self.baseUrl + '/api/provincias').then(function(response){
                    self.provincias = response.data;
                });
            },

            setRoute:function(type,id){
                this.bringFilters = type + '/' + id;
                this.activeTable = 'FiltersRanking';
            },

            back:function(){
                if (!this.activeTable && this.activeFilters) this.activeFilters = null;
                else this.activeTable = null;
                
            },
        }
    }
</script>
