<template> 

   <div class="panel-body container-fluid">
        <div class="carousel slide" data-ride="carousel" data-interval="false" id="carousel">
            <div class="carousel-inner" id="panels">
                <!-- Communidads panel -->
                <div class="row item active">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                        <p v-for="index in (1, commCount/2)" @click="openCommunidad(comms[index-1].id)">
                            <img :src="imageSource(comms[index-1].id)" height="24" width="32">&nbsp;
                            <a>{{comms[index-1].nombre}}</a> ({{comms[index-1].cimas.length}})
                        </p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                        <p v-for="index in (1, commCount/2)" @click="openCommunidad(comms[index+commCount/2-1].id)">
                            <img :src="imageSource(comms[index+commCount/2-1].id)" height="24" width="32">&nbsp;
                            <a>{{comms[index+commCount/2-1].nombre}}</a> ({{comms[index+commCount/2-1].cimas.length}})
                        </p>
                    </div>
                </div>

                <!-- Provincias panel -->
                <div class="row item">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center"  v-if="communidad">
                        <h3>
                            <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;&nbsp;{{communidad.nombre}}
                            <a class="pull-left" @click="back">Atras</a>
                        </h3>

                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center"  v-if="communidad">
                        <p v-for="provincia in communidad.provincias" @click="openProvince(provincia.id)">
                            <a>{{provincia.nombre}}</a>
                        </p>
                    </div>
                </div>

                <!-- Cimas panel -->
                <div class="row item">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center" v-if="province">
                        <h3>
                            <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;&nbsp;{{communidad.nombre}} -- {{province.nombre}}
                            <a class="pull-left" @click="back">Atras</a>
                        </h3>

                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                        <table class="table table-striped">
                            <thead>
                                <td>Cdg.</td><td>Nombre</td><td>Altitud</td><td>Vertientes</td>
                            </thead>
                            <tbody>
                                <tr v-for="cima in currentCimas" v-if="cima.estado === 1">
                                    <td>{{cima.codigo}}</td>
                                    <td>
                                        <a @click="openCima(cima.id)">{{cima.nombre}}</a>
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
                                <tr v-for="cima in currentCimas" v-if="cima.estado !== 1">
                                    <td>{{cima.codigo}}</td>
                                    <td>
                                        <a @click="openCima(cima.id)">{{cima.nombre}}</a>
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
                <div class="row item">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center" v-if="currentCima">
                        <h3>
                            <a class="pull-left" @click="back">Atras</a>
                            <a @click="previousCima">ANTERIOR</a>
                            <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;&nbsp;
                            {{currentCima.codigo}} -- {{currentCima.nombre}}
                            <a @click="nextCima">SIGUIENTE</a>
                        </h3>
                        <cimadetail class="item active" v-if="currentCima" :cima="currentCima"></cimadetail>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


</template>

<script>

    export default {
        props: ["communidads","cimas"],
        data: function() {
            return {
                panel: 0,
                communidad: null,
                province: null,
                currentCimas: null,
                currentCima: null,
            };
        },
        computed: {

        },

        beforeMount: function() {
            this.comms = JSON.parse(this.communidads);
            this.commCount = Object.keys(this.comms).length;
            this.baseCimas = JSON.parse(this.cimas);
        },

        methods: {

            /*
             * Moves Back to a previous panel setting the index
             */

            back: function(){
                this.panel = this.panel - 1;
                $('#carousel').carousel(this.panel);
            },

            /*
             * Gets a communidad image flag link
             */

            imageSource: function(id){
                var baseUrl = window.location.origin === "http://79.137.45.63" ? "http://79.137.45.63/retocima/public/" : "";
                return baseUrl + "/img/communidads/"+id+".png";
            },

            getLink:function(id){
                return "/detallescima/" + id;
            },

            /*
             * Opens communidad panel
             */

            openCommunidad:function(id){
                this.communidad = this.comms[id -1];
                this.panel = this.panel + 1;
                $('#carousel').carousel(this.panel);
            },

            /*
             * Opens province panel
             */

            openProvince:function(id){
                this.currentCimas = this.baseCimas.filter(function(cima){
                    return cima.provincia_id === id;
                }).sort(function(a,b) {return a.codigo < b.codigo ? -1 : 1});
                this.province = this.communidad.provincias.filter(function(provincia){
                    return provincia.id === id;
                })[0];
                this.panel = this.panel + 1;
                $('#carousel').carousel(this.panel);
            },

            /*
             * Opens cima panel
             */

            openCima:function(id){
                this.currentCima = this.baseCimas.filter(function(cima){
                    return cima.id === id;
                })[0];
                this.panel = this.panel + 1;
                $('#carousel').carousel(this.panel);
            },

            /* 
             * Show Previous Cima
             */

            previousCima:function(){
                var currentId = this.currentCima.id;
                var currentIndex = null;
                var index = this.currentCimas.forEach(function(cima,i){
                    if (cima.id === currentId) currentIndex = i;
                });
                this.currentCima = this.currentCimas[currentIndex -1];
                this.$emit('update', this.currentCima);

            },

            /* 
             * Show nextCima
             */

            nextCima:function(){
                var currentId = this.currentCima.id;
                var currentIndex = null;
                var index = this.currentCimas.forEach(function(cima,i){
                    if (cima.id === currentId) currentIndex = i;
                });
                this.currentCima = this.currentCimas[currentIndex + 1];
                this.$emit('update', this.currentCima);
            },

        },

    }

</script>
