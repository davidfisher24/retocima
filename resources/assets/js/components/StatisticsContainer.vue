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

    .dropdown {
        position: relative;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        top:45px;
        left:0px;
        background-color: #f9f9f9;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>

<template> 
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="sidebar-nav">
                <div class="navbar navbar-default" role="navigation">
                    <div class="">
                        <ul class="nav navbar-nav">
                            <li class="nav-item dropdown">
                                <!--<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    De Cimeros
                                </a>
                                <div class="dropdown-menu dropdown-content" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="ajax/statistics/cimerosbyprovincesstarted">Por provincias comenzadas</a></li>
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="ajax/statistics/cimerosbyprovincescompleted">Por provincias completadas</a></li>
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="ajax/statistics/cimerosbycommunidadscompleted">Por CC.AA. completadas</a></li>
                                </div>-->
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    De Cimas
                                </a>
                                <div class="dropdown-menu dropdown-content" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#" @click="activeTable = 'CimasRanking'">CIMAs más ascendidos</a></li>
                                    <li><a class="dropdown-item" @click="activeTable = 'ProvinciasRanking'">Provincias más ascendidas</a></li>
                                    <!--<li><a class="dropdown-item" @click="changeApiRoute" href="#" data-apiroute="ajax/statistics/provincesbycompletion">Provincias más completadas</a></li>-->
                                    <li><a class="dropdown-item" @click="activeTable = 'CommunidadsRanking'">CC.AA. más ascendidas</a></li>
                                    <!--<li><a class="dropdown-item" @click="changeApiRoute" href="#" data-apiroute="ajax/statistics/comunidadsbycompletion">CC.AA. más completadas</a></li>-->
                                </div>
                            </li>
                            <!-- Horrible dropdown panel -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Por Communidad Autonoma
                                </a>
                                <div class="dropdown-menu dropdown-content" aria-labelledby="navbarDropdownMenuLink">
                                    <li v-for="communidad in communidads">
                                        <a class="dropdown-item" href="#" @click="setRoute('communidad',communidad.id)">{{communidad.nombre}}</a>
                                    </li>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Por Provincia
                                </a>
                                <div class="dropdown-menu dropdown-content" aria-labelledby="navbarDropdownMenuLink">
                                    <li v-for="provincia in provincias">
                                        <a class="dropdown-item" href="#" @click="setRoute('provincia',provincia.id)">{{provincia.nombre}}</a>
                                    </li>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <div v-if="!activeTable"></div>
            <CimasRanking v-if="activeTable == 'CimasRanking'"></CimasRanking>
            <ProvinciasRanking v-if="activeTable == 'ProvinciasRanking'"></ProvinciasRanking>
            <CommunidadsRanking v-if="activeTable == 'CommunidadsRanking'"></CommunidadsRanking>
            <FiltersRanking v-if="activeTable == 'FiltersRanking'" :bringFilters="bringFilters"></FiltersRanking>
            <!--<div v-if="showcommunidads">
                <div v-for="communidad in communidads" style="display:inline-block;" class="tooltiptrigger">
                    <img :src="communidad.imageurl" @click="changeApiRoute"  :data-apiroute="communidad.apiroute" data-show="showcommunidads" style="width:30px;height:20px;margin:2px;">
                    <span class="tooltiptext">{{communidad.nombre}}</span>
                </div>
                
            </div>
            <div v-if="showprovinces">
                <a href="#" v-for="provincia in provincias" @click="changeApiRoute" :data-apiroute="provincia.apiroute" data-show="showprovinces">
                    {{provincia.nombre}}
                </a>
            </div>-->
            <!--<datatable v-for="route in routesCalled" v-if="tableLoaded && apiroute === route" :key="route"></datatable>-->
        </div>
    </div>
    </div>
</template>



<script>
import CimasRanking from './Tables/CimasRanking'
import ProvinciasRanking from './Tables/ProvinciasRanking'
import CommunidadsRanking from './Tables/CommunidadsRanking'
import FiltersRanking from './Tables/FiltersRanking'
    export default {
        components: {
            'CimasRanking': CimasRanking,
            'ProvinciasRanking': ProvinciasRanking,
            'CommunidadsRanking': CommunidadsRanking,
            'FiltersRanking' : FiltersRanking,
        },  

        data: function() {
            return {
                activeTable: null,
                bringFilters:null,
                //tableLoaded: false,
                //routesCalled: [],

                showprovinces: false,
                showcommunidads: false,
                provincias: [],
                communidads: [],
            };
        },

        mounted: function() {
            this.fetchComunidadsAndProvinces();
        },

        methods: {

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

            setRoute:function(type,id){
                this.activeTable = null;
                this.bringFilters = type + '/' + id;
                this.activeTable = 'FiltersRanking';
            },

        }
    }
</script>
