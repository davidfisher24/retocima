<style>
    .tooltiptrigger {

    }

    .tooltiptrigger .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }

    .tooltiptrigger:hover .tooltiptext {
        visibility: visible;
    }
</style>

<template> 
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 col-xl-3">
            <div class="sidebar-nav">
                <div class="navbar navbar-default" role="navigation">
                    <div class="">
                        <ul class="nav navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    De Cimeros
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="ajax/statistics/cimerosbyprovincesstarted">Por provincias comenzadas</a></li>
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="ajax/statistics/cimerosbyprovincescompleted">Por provincias completadas</a></li>
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="ajax/statistics/cimerosbycommunidadscompleted">Por CC.AA. completadas</a></li>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    De Cimas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="ajax/statistics/cimasbylogro">CIMAs más ascendidos</a></li>
                                    <li><a class="dropdown-item" @click="changeApiRoute" href="#" data-apiroute="ajax/statistics/provincesbylogro">Provincias más ascendidas</a></li>
                                    <li><a class="dropdown-item" @click="changeApiRoute" href="#" data-apiroute="ajax/statistics/provincesbycompletion">Provincias más completadas</a></li>
                                    <li><a class="dropdown-item" @click="changeApiRoute" href="#" data-apiroute="ajax/statistics/comunidadsbylogro">CC.AA. más ascendidas</a></li>
                                    <li><a class="dropdown-item" @click="changeApiRoute" href="#" data-apiroute="ajax/statistics/comunidadsbycompletion">CC.AA. más completadas</a></li>
                                </div>
                            </li>
                            <li><a href="#" @click="showcommunidads = true; showprovinces = false;">Por Comunidad Autonoma</a></li>
                            <li><a href="#" @click="showprovinces = true; showcommunidads = false;">Por Provincia</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div v-if="showcommunidads">
                <div v-for="communidad in communidads" style="display:inline-block;" class="tooltiptrigger">
                    <img :src="communidad.imageurl" @click="changeApiRoute"  :data-apiroute="communidad.apiroute" data-show="showcommunidads" style="width:30px;height:20px;margin:2px;">
                    <span class="tooltiptext">{{communidad.nombre}}</span>
                </div>
                
            </div>
            <div v-if="showprovinces">
                <a href="#" v-for="provincia in provincias" @click="changeApiRoute" :data-apiroute="provincia.apiroute" data-show="showprovinces">
                    {{provincia.nombre}}
                </a>
            </div>
            <datatable v-for="route in routesCalled" v-if="tableLoaded && apiroute === route" :key="route"></datatable>
        </div>
    </div>
</template>



<script>
    export default {
        data: function() {
            return {
                tableLoaded: false,
                apiroute: false,
                routesCalled: [],

                showprovinces: false,
                showcommunidads: false,
                provincias: [],
                communidads: [],
            };
        },
        computed: {


        },

        mounted: function() {
            this.fetchComunidadsAndProvinces();
        },

        methods: {

            /**
             * Triggers a change of table on changing api route
             * @trigger changeApiRoute() click envent
             * @param event
             * @result changes the visible table via ajax
            */

            changeApiRoute: function(event){

                this.showcommunidads = event.target.dataset.show === "showcommunidads" ? true : false;
                this.showprovinces = event.target.dataset.show === "showprovinces" ? true : false;


                if (this.routesCalled.indexOf(event.target.dataset.apiroute) === -1)
                    this.routesCalled.push(event.target.dataset.apiroute);
                this.apiroute = event.target.dataset.apiroute;
                this.tableLoaded = true;
            },

            /**
             * Gets a list of provinces and communidads for filtering
             * @trigger mounted()
             * @result stores the options with correct api routes
            */

            fetchComunidadsAndProvinces:function(){
                var self = this;

                axios.get('ajax/communidads').then(function(response){
                    response.data.forEach(function(item){
                        item.apiroute = 'ajax/statistics/cimerosbylogroinzones/communidad_id/' + item.id;
                        item.imageurl = 'img/communidads/' + item.id + '.png';
                    });
                    self.communidads = response.data;

                });

                axios.get('ajax/provincias').then(function(response){
                    response.data.forEach(function(item){
                        item.apiroute = 'ajax/statistics/cimerosbylogroinzones/provincia_id/' + item.id;
                    });
                    self.provincias = response.data;
                });
            },

        }
    }
</script>
