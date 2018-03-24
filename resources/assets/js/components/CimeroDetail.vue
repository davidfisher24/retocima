<template> 
<v-app>
    <v-container fluid>   
        <v-layout wrap>
            <v-flex md3 xs12>
                <div class="panel panel-default" v-if="profile">
                    <div class="panel-heading text-center">
                        <span>Cimero No. {{profile.id}}</span>
                        <div class="panel-title ">
                            <strong>{{profile.nombre}} {{profile.apellido1}} {{profile.apellido2}}</strong> 
                            {{profile.provincia.nombre}} - {{profile.pais.nombre}}
                        </div>
                    </div>
                </div>
                <div class="panel panel-success" v-if="completions">
                    <div class="panel-heading">
                        <p class="panel-title">CCAA Completadas</p>
                    </div>
                    <div class="panel-body">
                        <p v-if="completions.communidads.length === 0">Ninguno todavia</p>
                        <p v-for="comm in completions.communidads">{{comm.nombre}}</p>
                    </div>
                </div>
                <div class="panel panel-success" v-if="completions">
                    <div class="panel-heading">
                        <p class="panel-title">Provincias Completadas</p>
                    </div>
                    <div class="panel-body">
                        <p v-if="completions.communidads.length === 0 && completions.provincias.length === 0">Ninguno todavia</p>
                        <p v-for="prov in completions.provincias">{{prov.nombre}}</p>
                    </div>
                </div>
            </div>
            </v-flex>
            <v-flex md9 xs12>
                <CimeroLogrosSummary v-if="logros" :logros="logros" :addedCimas="[]"></CimeroLogrosSummary>
            </v-flex>
        </v-layout>
    </v-container>
</v-app>

</template>



<script>
    import CimeroLogrosSummary from './Cimero/CimeroLogrosSummary';

    export default {
        components: {
            'CimeroLogrosSummary' : CimeroLogrosSummary,
        },

        props: ["id"],

        data: function() {
            return {
                logros: null,
                profile: null,
                completions: null,
            };
        },
        
        beforeMount: function(){
        },

        mounted: function() {
            this.loadProfile();
            this.loadLogros();
            this.loadCompletions();
        },

        watch: {
 
        },

        methods: {

            loadProfile: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/cimero/profile/'+this.id).then(function(response){
                   self.profile = response.data;
                });
            },
      

            loadLogros: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/cimero/logros/'+this.id).then(function(response){
                   self.logros = response.data;
                });
            },

            loadCompletions: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/cimero/completions/'+this.id).then(function(response){
                   self.completions = response.data;
                });
            },
      
        }
    }
</script>
