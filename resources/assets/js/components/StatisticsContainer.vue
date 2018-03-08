<template> 
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12" v-if="!activeTable && !activeFilters">
            <h3>Choose what you want to see:</h3>
            <ul>
                <!-- cimeros provincia started -->
                <!-- cimeros provincias completed -->
                <!-- cimeros communidads completed -->
                <li><a @click="activeTable = 'CimasRanking'">Las CIMAs más ascendidos</a></li>
                <li><a @click="activeTable = 'ProvinciasRanking'">Las Provincias más ascendidas</a></li>
                <!-- Provincias most completed -->
                <li><a @click="activeTable = 'CommunidadsRanking'">Las CC.AA más ascendidas</a></li>
                <!-- Communidads most completed -->
                <li><a @click="activeFilters = 'provincias'">Ranking de cimeros por provincia</a></li>
                <li><a @click="activeFilters = 'communidads'">Ranking de cimeros por communidad</a></li>
            </ul>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12" v-if="!activeTable && activeFilters == 'provincias'">
            <a href="#" @click="back">Atras</a>
            <ul><li v-for="provincia in provincias">
                <a href="#" @click="setRoute('provincia',provincia.id)">{{provincia.nombre}}</a>
            </li></ul>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12" v-if="!activeTable && activeFilters == 'communidads'">
            <a href="#" @click="back">Atras</a>
            <ul><li v-for="communidad in communidads">
                <a href="#" @click="setRoute('communidad',communidad.id)">{{communidad.nombre}}</a>
            </li></ul>
        </div>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12" v-if="activeTable">
            <a href="#" @click="back">Atras</a>
            <CimasRanking v-if="activeTable == 'CimasRanking'"></CimasRanking>
            <ProvinciasRanking v-if="activeTable == 'ProvinciasRanking'"></ProvinciasRanking>
            <CommunidadsRanking v-if="activeTable == 'CommunidadsRanking'"></CommunidadsRanking>
            <FiltersRanking v-if="activeTable == 'FiltersRanking'" :bringFilters="bringFilters"></FiltersRanking>
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
                activeFilters: null,
                bringFilters:null,
                provincias: [],
                communidads: [],
            };
        },

        mounted: function() {
            this.fetchComunidadsAndProvinces();
        },

        methods: {
            
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
