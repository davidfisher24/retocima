
<template> 

   <div class="panel-body container-fluid">
                <!-- Communidads panel -->

                <div class="row" v-if="!cimas && !cima">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                       <p v-for="(communidad,index) in comms" v-if="index < count/2" class="communidad">
                            <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;
                            <a @click="selectCommunidad(communidad.id)" >{{communidad.nombre}}</a> ({{communidad.cimas_count}})
                            <ul v-if="selectedCommunidad === communidad.id">
                                <li v-for="provincia in communidad.provincias" @click="showProvince(provincia.id)">{{provincia.nombre}}</li>
                            </ul>
                        </p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                        <p v-for="(communidad,index) in comms" v-if="index >= count/2" class="communidad">
                            <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;
                            <a @click="selectCommunidad(communidad.id)" >{{communidad.nombre}}</a> ({{communidad.cimas_count}})
                            <ul v-if="selectedCommunidad === communidad.id">
                                <li v-for="provincia in communidad.provincias" @click="showProvince(provincia.id)">{{provincia.nombre}}</li>
                            </ul>
                        </p>
                    </div>
                </div>

                <!-- Cimas panel -->
                <div class="row" v-if="cimas && !cima">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                        <h3>
                            <img :src="imageSource(cimas[0].communidad_id)" height="24" width="32">&nbsp;&nbsp;{{cimas[0].communidad}} -- {{cimas[0].provincia}}
                            <a class="pull-left" @click="cimas = null, cimasmap = false">Atras</a>
                            <a class="pull-left" @click="cimasmap = !cimasmap">
                                <span v-if="!cimasmap">&nbsp;&nbsp;Ver Mapa</span>
                                <span v-if="cimasmap">&nbsp;&nbsp;Ver Lista</span>
                            </a>
                        </h3>
                    </div>
                    <!-- Simple list -->
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center" v-if="!cimasmap">
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
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center" v-if="cimasmap">
                        <ProvinceMap :cimas="cimas"></ProvinceMap>
                    </div>
                </div>

                <!-- Cima Panel -->
                <div class="row" v-if="cima">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                        <h3>
                            <a class="pull-left" @click="cima = null">Atras</a>
                            <a v-if="cimas.indexOf(cima) !== 0" @click="cima = cimas[cimas.indexOf(cima) -1]">ANTERIOR</a>
                            <!--<img :src="imageSource(cima.communidad_id)" height="24" width="32">&nbsp;&nbsp;
                            {{cima.codigo}} -- {{cima.nombre}} -->
                            <a v-if="cimas.indexOf(cima) + 1 !== cimas.length" @click="cima = cimas[cimas.indexOf(cima) +1]">SIGUIENTE</a>
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


            
        },

    }

</script>
