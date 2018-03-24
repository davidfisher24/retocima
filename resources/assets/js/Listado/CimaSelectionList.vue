<template> 
<v-app>
    <loadingcontainer v-if="loading"></loadingcontainer>
    <v-container v-show="!cimas && !cima && !loading" fluid>
      <v-layout row wrap>
            <v-flex xs12 class="mx-3">
                <v-text-field
                  label="Buscar"
                  v-model="searchInput"
                  clearable
                  :error-messages="searchNotFound"
                ></v-text-field>
                <v-list v-if="searchCimas.length > 0">
                    <v-list-tile v-for="cima in searchCimas" :key="cima.id">
                        <v-list-tile-content @click="showCimaFromSearch(cima)">
                            <v-list-tile-title>{{cima.nombre}}</v-list-tile-title>
                            <v-list-tile-sub-title>{{cima.communidad}} / {{cima.provincia}}</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-flex>
        </v-layout>
      <ProvinciaSelection v-show="!loading && searchCimas.length === 0" @mounted="loading = false" @chosen="showProvince"></ProvinciaSelection>
    </v-container>

    <v-container v-if="cimas && !cima && !loading" fluid>
        <v-layout row wrap>
            <v-flex xs12 class="mx-3">
                <v-toolbar>
                <v-toolbar-title>
                    <Flag :id="cimas[0].communidad_id"></Flag>
                    {{cimas[0].communidad}} - {{cimas[0].provincia}}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat color="info" @click="cimas = null, cimasmap = false">Atras</v-btn>
                  <v-btn flat color="info" @click="cimasmap = !cimasmap" v-if="!cimasmap">Mapa</v-btn>
                  <v-btn flat color="info" @click="cimasmap = !cimasmap" v-if="cimasmap">Lista</v-btn>
                </v-toolbar-items>
              </v-toolbar>

                <v-data-table
                    v-if="!cimasmap"
                    :headers="provinciaSectionHeaders"
                    :items="cimas"
                    hide-actions
                    class="elevation-1"
                  >
                    <template slot="items" slot-scope="props">
                      <tr @click="showCima(props.item.id)" v-if="props.item.estado === 1">
                          <td>{{ props.item.codigo }}</td>
                          <td>{{ props.item.nombre }}</td>
                          <td class="text-xs-right">{{ props.item.logros_count }}</td>
                          <td class="text-xs-right"><span v-if="props.item.vertientes[0]">{{ props.item.vertientes[0].altitud}}m</span></td>
                          <td class="hidden-sm-and-down">
                            <p v-for="vert in props.item.vertientes">{{vert.vertiente}}</p>
                          </td>
                          <td class="hidden-md-and-up">
                            <v-badge>
                              <span slot="badge">{{props.item.vertientes.length}}</span>
                            </v-badge>
                          </td>
                      </tr>
                    </template>
                  </v-data-table>
                  <v-subheader v-if="!cimasmap && needCimasElimitedRow()"><p class="subheading">Cimas que fueron eliminadas o sustituidas</p></v-subheader>
                  <v-data-table
                    v-if="!cimasmap && needCimasElimitedRow()"
                    :headers="provinciaSectionHeaders"
                    :items="cimas"
                    hide-actions
                    hide-headers
                    class="elevation-1"
                  >

                    <template slot="items" slot-scope="props">
                      <tr @click="showCima(props.item.id)" v-if="props.item.estado !== 1">
                          <td>{{ props.item.codigo }}</td>
                          <td>{{ props.item.nombre }}</td>
                          <td class="text-xs-right">{{ props.item.logros_count }}</td>
                          <td class="text-xs-right"><span v-if="props.item.vertientes[0]">{{ props.item.vertientes[0].altitud}}m</span></td>
                          <td class="hidden-sm-and-down">
                            <p v-for="vert in props.item.vertientes">{{vert.vertiente}}</p>
                          </td>
                          <td class="hidden-md-and-up">
                            <v-badge>
                              <span slot="badge">{{props.item.vertientes.length}}</span>
                            </v-badge>
                          </td>
                      </tr>
                    </template>
                  </v-data-table>
                <CimaMap v-if="cimasmap" :cimas="cimas" @chooseCima="showCima"></CimaMap>
            </v-flex>
        </v-layout>
    </v-container>

    <v-container v-if="cima && !loading" fluid>
        <v-layout row wrap>
            <v-flex xs12 class="mx-3">
                <v-toolbar color="primary">
                <v-toolbar-title class="white--text">{{cima.codigo}} {{cima.nombre}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat color="white" @click="cima = null">Atras</v-btn>
                  <v-btn flat color="white" v-if="cimas" @click="previousCima()">Anterior</v-btn>
                  <v-btn flat color="white" v-if="cimas" @click="nextCima()">Siguiente</v-btn>
                </v-toolbar-items>
              </v-toolbar color="secondary">
              <v-system-bar status color="primary" dark>
                <span>{{cima.provincia}} / {{cima.communidad}}</span>
              </v-system-bar>
              <v-system-bar status color="primary" dark>
                <span>GPS:  Latitude: {{cima.latitude}}  Longitude: {{cima.longitude}}</span>
              </v-system-bar>
              <CimaDetail class="item" :cima="cima"></CimaDetail>>
            </v-flex>
        </v-layout>
    </v-container>
</v-app>


</template>


<script>

    import ProvinciaSelection from '../components/ProvinciaSelection';
    import CimaMap from '../components/Maps/CimaMap';
    import CimaDetail from './CimaDetail';
    import Flag from '../components/Flag';

    export default {
        components: {
            'ProvinciaSelection' : ProvinciaSelection,
            'CimaMap' : CimaMap,
            'CimaDetail' : CimaDetail,
            'Flag' : Flag,
        },

        data: function() {
            return {
                loading: true,
                selectedCommunidad: null,
                cimas: null,
                cimasmap: false,
                cima: null,
                searchInput: "",
                searchCimas: [],
                searchNotFound: [],


                provinciaSectionHeaders: [
                  { text: 'Cdg',sortable: false, },
                  { text: 'Nombre',sortable: false, },
                  { text: 'Logros',sortable: false, },
                  { text: 'Altitud',sortable: false, },
                  { text: 'Vertientes',sortable: false, },
                ],

            };
        },


        methods: {

            showProvince: function(id){
                
                var self = this;
                this.loading = true;
                axios.get(this.baseUrl + '/api/cimas/' + id).then(function(response){
                    self.cimas = response.data;
                    self.loading = false;
                });
            },

            needCimasElimitedRow:function(){
                return this.cimas.filter(function(c){ return c.estado != 1 }).length ? true : false;
            },

            showCima: function(id){
                var self = this;
                this.loading = true;
                this.cimas.forEach(function(cima){
                    if (id === cima.id) self.cima = cima;
                    self.loading = false;
                })
            },

            previousCima: function(){
                var newIndex;
                var index = this.cimas.indexOf(this.cima);
                if (index === 0) newIndex = this.cimas.length - 1;
                else newIndex = index -1;
                this.cima = this.cimas[newIndex];
            },

            nextCima: function(){
                var newIndex;
                var index = this.cimas.indexOf(this.cima);
                if (index === this.cimas.length - 1) newIndex = 0;
                else newIndex = index +1;
                this.cima = this.cimas[newIndex];
            },

            showCimaFromSearch: function(cima){
                this.searchCimas = [];
                this.searchInput = "";
                this.cima = cima;
            },

            searchDisplay: function(){
                if (this.searchCimas.length === 0 && this.searchNotFound.length === 0) return "display:none;"
                return "display:block;"
            },

            clearSearch: function() {
                this.searchCimas = [];
                this.searchInput = "";
            },

            searchCimasAjax: _.debounce(
              function () {
                var self = this;
                axios.get(this.baseUrl + '/api/cimas/search/' + this.searchInput).then(function(response){
                    self.searchCimas = [];
                    if (response.data.length === 0) {
                        self.searchNotFound = ["Nada Encontrado"];
                        return;
                    }
                    self.searchNotFound = [];
                    var i = 0;
                    while (self.searchCimas.length <= 10 && response.data.length > i) {
                        if(response.data[i]) self.searchCimas.push(response.data[i]);
                        i++;
                    }
                });
              },500),

        },

        watch: {
          searchInput: function (val) {
            if (!this.searchInput || this.searchInput.length < 3) {
                this.searchNotFound = [];
                this.searchCimas = [];
                return;
            }
            this.searchCimasAjax();
          },
        },

    }

</script>
