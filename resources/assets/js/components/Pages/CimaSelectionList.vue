

<template> 

   <div class="panel-body container-fluid">
                <loadingcontainer v-if="loading"></loadingcontainer>
                <!-- Search box -->
                <div class="row panel-body" v-if="!cimas && !cima && !loading">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 btn-group">
                            <input type="search" class="form-control" placeholder="Buscar" v-model="searchInput" >
                            <span class="glyphicon glyphicon-remove-circle search-clear" @click="clearSearch"></span>
                            <ul class="dropdown-menu search-option-menu" :style="searchDisplay()">
                               <p v-if="searchNotFound" class="search-option search-not-found">Nada Encontrado</p>
                               <p v-for="cima in searchCimas" class="search-option" @click="showCimaFromSearch(cima)">
                                        <span class="breadcrumb-item h4">{{cima.nombre}}</span> /
                                        <span class="breadcrumb-item">{{cima.communidad}}</span> /
                                        <span class="breadcrumb-item">{{cima.provincia}}</span>
                                </p>
                            </ul>
                    </div>
                </div>

                <!-- Communidads panel -->
                <div class="row" v-if="!cimas && !cima && !loading">
                    <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 text-left">
                       <div v-for="(communidad,index) in comms" v-if="index < count/2"  @click="selectCommunidad(communidad.id)" >
                           <p class="select-option bg-light">
                                <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;
                                <a>{{communidad.nombre}}</a> 
                                <span class="badge pull-right">{{communidad.cimas_count}}</span>
                            </p>
                            <div v-if="selectedCommunidad === communidad.id">
                                <p v-for="provincia in communidad.provincias" @click="showProvince(provincia.id)" class="select-option">
                                    <a>{{provincia.nombre}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 text-left">
                        <div v-for="(communidad,index) in comms" v-if="index >= count/2"  @click="selectCommunidad(communidad.id)" >
                            <p class="select-option">
                                <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;
                                <a>{{communidad.nombre}}</a> 
                                <span class="badge pull-right">{{communidad.cimas_count}}</span> 
                            </p>
                            <div v-if="selectedCommunidad === communidad.id">
                                <p v-for="provincia in communidad.provincias" @click="showProvince(provincia.id)" class="select-option">
                                    <a>{{provincia.nombre}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cimas panel -->
                <div class="row panel" v-if="cimas && !cima && !loading">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center panel-header">
                        <img :src="imageSource(cimas[0].communidad_id)" height="24" width="32">&nbsp;&nbsp;
                        <span class="h3 hidden-sm hidden-xs">{{cimas[0].communidad}} /</span> 
                        <span class="h3">{{cimas[0].provincia}}</span>

                        <button class="pull-left btn btn-default breadcrumb" @click="cimas = null, cimasmap = false">Atras</button>
                        <button class="pull-right btn btn-default breadcrumb" @click="cimasmap = !cimasmap">
                            <span v-if="!cimasmap">Ver Mapa</span>
                            <span v-if="cimasmap">Ver Lista</span>
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <!-- Simple list -->
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center panel-body fake-table" v-if="!cimasmap">
                        <div class="row row-header">
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p>Cdg.</p></div>
                            <div class="col-md-4 col-xs-4 col-lg-4 col-xl-4 col-sm-4"><p>Nombre</p></div>
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p>Logros</p></div>
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p>Altitud</p></div>
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p>Verts.</p></div>
                        </div>
                        <div class="row row-link" v-for="cima in cimas" v-if="cima.estado === 1" @click="showCima(cima.id)">
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p>{{cima.codigo}}</p></div>
                            <div class="col-md-4 col-xs-4 col-lg-4 col-xl-4 col-sm-4"><a>{{cima.nombre}}</a></div>
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p>{{cima.logros_count}}</p></div>
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p v-if="cima.vertientes[0]">{{cima.vertientes[0].altitud}}m</p></div>
                            <div class="col-md-2 col-lg-2 col-xl-2 hidden-xs hidden-sm"><p v-if="cima.vertientes[0]" v-for="vertiente in cima.vertientes">{{vertiente.vertiente}}</p></div>
                            <div class="hidden-xl hidden-lg hidden-md col-xs-2 col-sm-2"><span class="badge">{{cima.vertientes.length}}</span></div>
                        </div>
                        <div class="row row-delimiter" v-if="needCimasElimitedRow()">
                            <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12 col-sm-12 text-center"><p>Cimas que fueron eliminados</p></div>
                        </div>
                        <div class="row row-link" v-for="cima in cimas" v-if="cima.estado !== 1" @click="showCima(cima.id)">
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p>{{cima.codigo}}</p></div>
                            <div class="col-md-4 col-xs-4 col-lg-4 col-xl-4 col-sm-4"><a>{{cima.nombre}}</a></div>
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p>{{cima.logros_count}}</p></div>
                            <div class="col-md-2 col-xs-2 col-lg-2 col-xl-2 col-sm-2"><p v-if="cima.vertientes[0]">{{cima.vertientes[0].altitud}}m</p></div>
                            <div class="col-md-2 col-lg-2 col-xl-2 hidden-xs hidden-sm"><p v-if="cima.vertientes[0]" v-for="vertiente in cima.vertientes">{{vertiente.vertiente}}</p></div>
                            <div class="hidden-xl hidden-lg hidden-md col-xs-2 col-sm-2"><span class="badge">{{cima.vertientes.length}}</span></div>
                        </div>
                    </div>
                    <!-- Map list-->
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 google-map-column"v-if="cimasmap">
                        <ProvinceMap :cimas="cimas"></ProvinceMap>
                    </div>
                </div>

                <!-- Cima Panel -->
                <div class="row panel panel-default" v-if="cima && !loading">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center panel-header">
                        <span class="h3">{{cima.codigo}} {{cima.nombre}}</span>
                        <button class="pull-left btn btn-default breadcrumb" @click="cima = null">Atras</button>
                        <button class="pull-right btn btn-default breadcrumb" v-if="cimas && cimas.indexOf(cima) + 1 !== cimas.length" @click="cima = cimas[cimas.indexOf(cima) +1]">Siguiente</button>
                        <button class="pull-right btn btn-default breadcrumb" v-if="cimas && cimas.indexOf(cima) !== 0" @click="cima = cimas[cimas.indexOf(cima) -1]">Anterior</button>
                        <div class="clearfix"></div>
                        <span class="h4">{{cima.communidad}} / {{cima.provincia}}</span>
                    </div>

                    <cimadetail class="item" :cima="cima"></cimadetail>
                </div>
    </div>


</template>


<script>

    import ProvinceMap from '../Maps/ProvinceMap';

    export default {
        components: {
            'ProvinceMap' : ProvinceMap,
        },

        data: function() {
            return {
                loading: true,
                comms: [],
                count: 0,
                selectedCommunidad: null,
                cimas: null,
                cimasmap: false,
                cima: null,
                searchInput: "",
                searchCimas: [],
                searchNotFound: false,
            };
        },

        beforeMount:function(){
        },

        mounted:function(){
            var self = this;
            axios.get(this.baseUrl + '/api/communidads').then(function(response){
                self.comms = response.data;
                self.count = Object.keys(self.comms).length
                self.loading = false;
            });
        },

        methods: {


            imageSource: function(id){
                return this.baseUrl + "/img/communidads/"+id+".png";
            },

            selectCommunidad: function(id){
                if (this.selectedCommunidad === id) return this.selectedCommunidad = null;
                this.selectedCommunidad = id;
            },

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
                    if (id === cima.id) return self.cima = cima;
                    self.loading = false;
                })
            },


            showCimaFromSearch: function(cima){
                this.searchCimas = [];
                this.searchInput = "";
                this.cima = cima;
            },

            searchDisplay: function(){
                if (this.searchCimas.length === 0 && !this.searchNotFound) return "display:none;"
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
                        self.searchNotFound = true;
                        return;
                    }
                    self.searchNotFound = false;
                    var i = 0;
                    while (self.searchCimas.length < 4 && response.data.length > i) {
                        if(response.data[i]) self.searchCimas.push(response.data[i]);
                        i++;
                    }
                });
              },500),

            
        },

        watch: {
          searchInput: function () {
            if (this.searchInput.length < 3) {
                this.searchNotFound = false;
                this.searchCimas = [];
                return;
            }
            this.searchCimasAjax();
          }
        },

    }

</script>
