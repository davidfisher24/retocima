<template> 
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12" v-if="!activeTable && !activeFilters">
                <!-- cimeros provincia started -->
                <p class="select-option" @click="activeTable = 'CimerosRanking', route='provinciasstarted'"><a>Cimeros por Provincias comenzados</a></p>
                <!-- cimeros provincias completed -->
                <!-- cimeros communidads completed -->
                <p class="select-option" @click="activeTable = 'CimasRanking'"><a>Las CIMAs más ascendidos</a></p>
                <p class="select-option" @click="activeTable = 'ProvinciasRanking'"><a>Las Provincias más ascendidas</a></p>
                <!-- Provincias most completed -->
                <p class="select-option" @click="activeTable = 'CommunidadsRanking'"><a>Las CC.AA más ascendidas</a></p>
                <!-- Communidads most completed -->
                <p class="select-option" @click="activeFilters = 'provincias'"><a>Ranking de cimeros por provincia</a></p>
                <p class="select-option" @click="activeFilters = 'communidads'"><a>Ranking de cimeros por communidad</a></p>
        </div>



        <div class="row panel" v-if="!activeTable && activeFilters == 'provincias'">
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center panel-header">
                <span class="h3">Provincias</span>
                <button class="pull-left btn btn-default breadcrumb" @click="back">Atras</button>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-3 col-xl-3"  v-for="chunk in chunkedProvinces">
                <p class="select-option" v-for="provincia in chunk" @click="setRoute('provincia',provincia.id)"><a>{{provincia.nombre}}</a></p>
            </div>
        </div>

        <div class="row panel" v-if="!activeTable && activeFilters == 'communidads'">
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center panel-header">
                <span class="h3">Communidads</span>
                <button class="pull-left btn btn-default breadcrumb" @click="back">Atras</button>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6"  v-for="chunk in chunkedCommunidads">
                <p class="select-option" v-for="communidad in chunk"@click="setRoute('communidad',communidad.id)"><a>{{communidad.nombre}}</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12" v-if="activeTable">
                <a href="#" @click="back">Atras</a>
                <CimerosRanking v-if="activeTable == 'CimerosRanking'" :route="route"></CimerosRanking>
                <CimasRanking v-if="activeTable == 'CimasRanking'"></CimasRanking>
                <ProvinciasRanking v-if="activeTable == 'ProvinciasRanking'"></ProvinciasRanking>
                <CommunidadsRanking v-if="activeTable == 'CommunidadsRanking'"></CommunidadsRanking>
                <FiltersRanking v-if="activeTable == 'FiltersRanking'" :bringFilters="bringFilters"></FiltersRanking>
            </div>
        </div>
    </div>
    </div>
</template>



<script>
import CimerosRanking from '../Tables/CimerosRanking'
import CimasRanking from '../Tables/CimasRanking'
import ProvinciasRanking from '../Tables/ProvinciasRanking'
import CommunidadsRanking from '../Tables/CommunidadsRanking'
import FiltersRanking from '../Tables/FiltersRanking'
    export default {
        components: {
            'CimerosRanking' : CimerosRanking,
            'CimasRanking': CimasRanking,
            'ProvinciasRanking': ProvinciasRanking,
            'CommunidadsRanking': CommunidadsRanking,
            'FiltersRanking' : FiltersRanking,
        },  

        data: function() {
            return {
                route:null,
                activeTable: null,
                activeFilters: null,
                bringFilters:null,
                provincias: [],
                communidads: [],
            };
        },

        computed: {
           chunkedCommunidads:function () {
            return _.chunk(this.communidads,this.communidads.length/2);
           },
           chunkedProvinces:function () {
            return _.chunk(this.provincias,this.provincias.length/4);
           }
        },

        mounted: function() {
            this.fetchComunidadsAndProvinces();
        },

        methods: {
            
            fetchComunidadsAndProvinces:function(){
                var self = this;

                axios.get(this.baseUrl + '/ajax/communidads').then(function(response){
                    response.data.forEach(function(item){
                        item.apiroute = self.baseUrl + '/ajax/statistics/cimerosbylogroinzones/communidad_id/' + item.id;
                        item.imageurl = self.baseUrl + '/img/communidads/' + item.id + '.png';
                    });
                    self.communidads = response.data;

                });

                axios.get('ajax/provincias').then(function(response){
                    response.data.forEach(function(item){
                        item.apiroute = self.baseUrl + '/ajax/statistics/cimerosbylogroinzones/provincia_id/' + item.id;
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
