<template> 

   <div class="panel-body container-fluid">
                <!-- Communidads panel -->

                <div class="row" v-if="!cimas && !cima">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                       <p v-for="(communidad,index) in comms" v-if="index < count/2">
                            <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;
                            <a @click="selectCommunidad(communidad.id)" >{{communidad.nombre}}</a> ({{communidad.cimas_count}})
                            <ul v-if="selectedCommunidad === communidad.id">
                                <li v-for="provincia in communidad.provincias" @click="showProvince(provincia.id)">{{provincia.nombre}}</li>
                            </ul>
                        </p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                        <p v-for="(communidad,index) in comms" v-if="index >= count/2">
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
                            <a class="pull-left" @click="cimas = null">Atras</a>
                        </h3>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                        <table class="table table-striped">
                            <thead>
                                <td>Cdg.</td><td>Nombre</td><td>Altitud</td><td>Vertientes</td>
                            </thead>
                            <tbody>
                                <tr v-for="cima in cimas" v-if="cima.estado === 1">
                                    <td>{{cima.codigo}}</td>
                                    <td>
                                        <a @click="showCima(cima.id)">{{cima.nombre}}</a>
                                    </td>
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
                                    <td><span v-if="cima.vertientes[0]">{{cima.vertientes[0].altitud}}m</span></td>
                                    <td>
                                        <p v-if="cima.vertientes[0]" v-for="vertiente in cima.vertientes">{{vertiente.vertiente}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Cima Panel -->
                <div class="row" v-if="cima">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                        <h3>
                            <a class="pull-left" @click="cima = null">Atras</a>
                            <a v-if="cimas.indexOf(cima) !== 0" @click="cima = cimas[cimas.indexOf(cima) -1]">ANTERIOR</a>
                            <img :src="imageSource(cima.communidad_id)" height="24" width="32">&nbsp;&nbsp;
                            {{cima.codigo}} -- {{cima.nombre}} 
                            <a v-if="cimas.indexOf(cima) + 1 !== cimas.length" @click="cima = cimas[cimas.indexOf(cima) +1]">SIGUIENTE</a>
                        </h3>
                        <cimadetail class="item" :cima="cima"></cimadetail>
                    </div>
                    
                </div>
    </div>


</template>


<script>

    export default {
        props: ["communidads"],
        data: function() {
            return {
                selectedCommunidad: null,
                cimas: null,
                cima: null,
            };
        },
        computed: {

        },

        beforeMount: function() {
            this.comms = JSON.parse(this.communidads);
            this.count = Object.keys(this.comms).length;
        },

        methods: {


            /*
             * Gets a communidad image flag link
             */

            imageSource: function(id){
                var baseUrl = window.location.origin === "http://79.137.45.63" ? "http://79.137.45.63/retocima/public/" : "";
                return baseUrl + "/img/communidads/"+id+".png";
            },

            selectCommunidad: function(id){
                if (this.selectedCommunidad === id) return this.selectedCommunidad = null;
                this.selectedCommunidad = id;
            },

            showProvince: function(id){
                var baseUrl = window.location.origin === "http://79.137.45.63" ? "http://79.137.45.63/retocima/public/" : "";
                var self = this;
                axios.get(baseUrl + '/api/cimas/' + id).then(function(response){
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
