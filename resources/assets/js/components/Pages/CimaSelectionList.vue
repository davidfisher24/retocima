<style>

.h4 {
    font-size:1.2em;
    font-weight:bold;
}



</style>


<template> 

   <div class="panel-body container-fluid">
                <!-- Search box -->
                <div class="row panel-body" v-if="!cimas && !cima">
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
                <div class="row" v-if="!cimas && !cima">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
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
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
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
                <div class="row panel" v-if="cimas && !cima">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center panel-header">
                        <ol class="breadcrumb">
                            <img :src="imageSource(cimas[0].communidad_id)" height="24" width="32">&nbsp;&nbsp;
                            <li class="breadcrumb-item"><span class="h4">{{cimas[0].communidad}}</span></li>
                            <li class="breadcrumb-item active"><span class="h4">{{cimas[0].provincia}}</span></li>
                        
                            <button class="pull-left btn btn-default" @click="cimas = null, cimasmap = false">Atras</button>
                            <button class="pull-right btn btn-default" @click="cimasmap = !cimasmap">
                                <span v-if="!cimasmap">Ver Mapa</span>
                                <span v-if="cimasmap">Ver Lista</span>
                            </button>
                        </ol>
                    </div>
                    <!-- Simple list -->
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center panel-body" v-if="!cimasmap">
                        <table class="table table-striped">
                            <thead>
                                <td>Cdg.</td><td>Nombre</td><td>logros</td><td>Altitud</td><td>Vertientes</td>
                            </thead>
                            <tbody>
                                <tr v-for="cima in cimas" v-if="cima.estado === 1">
                                    <td>{{cima.codigo}}</td>
                                    <td>
                                        <a @click="showCima(cima.id)">{{cima.nombre}}</a>
                                    </td>
                                    <td>{{cima.logros_count}}</td>
                                    <td><span v-if="cima.vertientes[0]">{{cima.vertientes[0].altitud}}m</span></td>
                                    <td>
                                        <p  v-if="cima.vertientes[0]" v-for="vertiente in cima.vertientes">{{vertiente.vertiente}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-striped">
                            <thead>
                                <td colspan="4">Cimas que fueron eliminados</td>
                            </thead>
                            <tbody>
                                <tr v-for="cima in cimas" v-if="cima.estado !== 1">
                                    <td>{{cima.codigo}}</td>
                                    <td>
                                        <a @click="showCima(cima.id)">{{cima.nombre}}</a>
                                    </td>
                                    <td>{{cima.logros_count}}</td>
                                    <td><span v-if="cima.vertientes[0]">{{cima.vertientes[0].altitud}}m</span></td>
                                    <td>
                                        <p v-if="cima.vertientes[0]" v-for="vertiente in cima.vertientes">{{vertiente.vertiente}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Map list-->
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 google-map-column"v-if="cimasmap">
                        <ProvinceMap :cimas="cimas"></ProvinceMap>
                    </div>
                </div>

                <!-- Cima Panel -->
                <div class="row" v-if="cima">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                        <h3>
                            <a class="pull-left" @click="cima = null">Atras</a>
                            <a v-if="cimas && cimas.indexOf(cima) !== 0" @click="cima = cimas[cimas.indexOf(cima) -1]">ANTERIOR</a>
                            <!--<img :src="imageSource(cima.communidad_id)" height="24" width="32">&nbsp;&nbsp;
                            {{cima.codigo}} -- {{cima.nombre}} -->
                            <a v-if="cimas && cimas.indexOf(cima) + 1 !== cimas.length" @click="cima = cimas[cimas.indexOf(cima) +1]">SIGUIENTE</a>
                        </h3>
                        <cimadetail class="item" :cima="cima"></cimadetail>
                    </div>
                    
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
                axios.get(this.baseUrl + '/api/cimas/' + id).then(function(response){
                    self.cimas = response.data;
                });
            },

            showCima: function(id){
                var self = this;
                this.cimas.forEach(function(cima){
                    if (id === cima.id) return self.cima = cima;
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
