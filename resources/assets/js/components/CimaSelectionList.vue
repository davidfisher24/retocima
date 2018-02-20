<template> 

   <div class="panel-body">
            <!-- Communidads panel -->
            <div class="row" v-if="section === 'communidads'">
                <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                    <p v-for="comm in comms1" @click="openCommunidad(comm.id)">
                        <img :src="imageSource(comm.id)" height="24" width="32">&nbsp;
                        <a>{{comm.nombre}}</a> ({{comm.cimas.length}})
                    </p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 col-xl-6 text-left">
                    <p v-for="comm in comms2" @click="openCommunidad(comm.id)">
                       <img :src="imageSource(comm.id)" height="24" width="32">&nbsp;
                        <a>{{comm.nombre}}</a> ({{comm.cimas.length}})
                    </p>
                </div>
            </div>

            <!-- Provinces panel -->
            <div class="row" v-if="section === 'provinces'">
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                    <h3>
                        <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;&nbsp;{{communidad.nombre}}
                        <a class="pull-left" @click="section = 'communidads'">Atras</a>
                    </h3>

                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                    <p v-for="provincia in communidad.provincias" @click="openProvince(provincia.id)">
                        <a>{{provincia.nombre}}</a>
                    </p>
                </div>
            </div>

            <!-- Cimas panel -->
            <div class="row" v-if="section === 'cimas'">
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                    <h3>
                        <img :src="imageSource(communidad.id)" height="24" width="32">&nbsp;&nbsp;{{communidad.nombre}} -- {{province.nombre}}
                        <a class="pull-left" @click="section = 'provinces'">Atras</a>
                    </h3>

                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
                    <table class="table table-striped">
                        <thead>
                            <td>Cdg.</td><td>Nombre</td>
                        </thead>
                        <tbody>
                            <tr v-for="cima in cimas" v-if="cima.estado === 1">
                                <td>{{cima.codigo}}</td>
                                <td>
                                    <a href="/detallescima/1" target="blank">{{cima.nombre}}</a>
                                </td>
                                <!--<td>{{cima.vertientes}}m</td>
                                <td>
                                    <span v-for="vertiente in cima.vertientes">{{vertiente.nombre}}</span>
                                </td>-->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</template>

<script>

    export default {
        props: ["communidads"],
        data: function() {
            return {
                section: 'communidads',
                communidad: null,
                cimas: null,
                province: null,
            };
        },
        computed: {

        },

        beforeMount: function() {
            this.organiseCommunidads();
        },

        methods: {
            imageSource: function(id){
                return "./img/communidads/"+id+".png";
            },

            organiseCommunidads: function(){
                this.baseCommunidads = JSON.parse(this.communidads);
                this.comms1 = [];
                this.comms2 = [];
                var count = Object.keys(this.baseCommunidads).length;
                var index = 1;
                for (var key in this.baseCommunidads) {
                    if (index <= count/2) this.comms1.push(this.baseCommunidads[key]);
                    else this.comms2.push(this.baseCommunidads[key]);
                    index++;
                }
            },

            openCommunidad:function(id){
                this.communidad = this.baseCommunidads[id -1];
                this.section = 'provinces';
            },

            openProvince:function(id){
                this.cimas = this.communidad.cimas.filter(function(cima){
                    return cima.provincia_id === id;
                });
                this.province = this.communidad.provincias.filter(function(provincia){
                    return provincia.id === id;
                })[0]
                this.section = 'cimas';
            },

        },

    }

</script>
