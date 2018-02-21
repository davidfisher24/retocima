<template> 
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center">
            Entrar Busqueda: <input type="text" name="text-search" v-model="searchText" @keyup="search">
            <!--<select name="provincia" v-model="searchProvince">
                <option value="">Todos</option>
                <option v-for="provincia in provincias" :val="provincia">{{provincia}}</option>
            </select>
            <select name="communidad" v-model="searchCommunidad">
                <option value="">Todos</option>
                <option v-for="communidad in communidads" :val="communidad">{{communidad}}</option>
            </select>
            <button class="btn btn-primary" @click="search">Go!</button>-->
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 text-center" v-if="filteredCimas">
            <table class="table table-striped">
                <thead>
                    <td>Cdg.</td><td>Nombre</td><td>Provincia</td><td>Communidad</td>
                </thead>
                <tbody>
                    <tr v-for="cima in filteredCimas">
                        <td>{{cima.codigo}}</td>
                        <td>
                            <a :href="getLink(cima.id)" target="blank">{{cima.nombre}}</a>
                        </td>
                        <td>{{cima.provincia}}</td>
                        <td>{{cima.communidad}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["cimas"],
        data: function() {
            return {
                baseCimas: null,
                filteredCimas: null,
                provincias: null,
                communidads: null,
                searchText: null,
                searchProvince: "",
                searchCommunidad: "",
            };
        },
        computed: {

        },

        beforeMount: function() {
            this.baseCimas = JSON.parse(this.cimas);
            this.getFilters();
        },

        methods: {

            getFilters:function(){
                var provincias = [];
                var communidads = [];
                this.baseCimas.forEach(function(cima){
                    if (provincias.indexOf(cima.provincia) === -1 ) provincias.push(cima.provincia);
                    if (communidads.indexOf(cima.communidad) === -1 ) communidads.push(cima.communidad);
                });
                this.provincias = provincias.sort(function(a,b){ return b > a ? -1 : 1 });
                this.communidads = communidads.sort(function(a,b){ return b > a ? -1 : 1 });
            },

            search:function(){
                var self = this;
                this.filteredCimas = this.baseCimas.filter(function(cima){
                    var filtered = false;
                    if (cima.nombre.toLowerCase().indexOf(self.searchText) !== -1) filtered = true;
                    //if (self.searchProvince && self.searchProvince === cima.provincia) filtered = true; 
                    return filtered;
                });
            },

            getLink:function(id){
                return "/detallescima/" + id;
            }

        }
    }

</script>
