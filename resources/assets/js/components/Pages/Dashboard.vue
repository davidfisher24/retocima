<template>
<v-app>
    <v-container>
      <v-layout row>
        <v-flex xs4>
        <v-navigation-drawer permanent>
            <v-list dense class="pt-0">

              <v-list-tile @click="section = 'edit'">
                <v-list-tile-action><v-icon>dashboard</v-icon></v-list-tile-action>
                <v-list-tile-content><v-list-tile-title>EDITAR CUENTA</v-list-tile-title></v-list-tile-content>
              </v-list-tile>

              <v-list-tile @click="section = 'summary'">
                <v-list-tile-action><v-icon>dashboard</v-icon></v-list-tile-action>
                <v-list-tile-content><v-list-tile-title>RESUMEN LOGROS</v-list-tile-title></v-list-tile-content>
              </v-list-tile>

              <v-list-tile @click="section = 'add'">
                <v-list-tile-action><v-icon>dashboard</v-icon></v-list-tile-action>
                <v-list-tile-content><v-list-tile-title>ANADIR CIMA</v-list-tile-title></v-list-tile-content>
              </v-list-tile>

              <v-list-tile @click="section = 'password'">
                <v-list-tile-action><v-icon>dashboard</v-icon></v-list-tile-action>
                <v-list-tile-content><v-list-tile-title>CAMBIAR CONTRASENA</v-list-tile-title></v-list-tile-content>
              </v-list-tile>

              <v-list-group no-action>
                <v-list-tile slot="activator">
                  <v-list-tile-action><v-icon>dashboard</v-icon></v-list-tile-action>
                  <v-list-tile-content><v-list-tile-title>ESTADISTICA</v-list-tile-title></v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="setStat('bar')">
                  <v-list-tile-content><v-list-tile-title>Logros por communidad</v-list-tile-title></v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="setStat('pie')">
                  <v-list-tile-content><v-list-tile-title>Logros por provincia</v-list-tile-title></v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="setStat('spline')">
                  <v-list-tile-content><v-list-tile-title>Altitud de mis cimas</v-list-tile-title></v-list-tile-content>
                </v-list-tile>
              </v-list-group>


            </v-list>
          </v-navigation-drawer>
        </v-flex>
        <v-flex xs8>
            <AddCimaForm v-if="section == 'add'"></AddCimaForm>
            <CimeroEditCuentaForm v-if="section == 'edit'"></CimeroEditCuentaForm>
            <CimeroLogrosSummary v-if="section == 'summary'" :logros="logros"></CimeroLogrosSummary>
            <CimeroStatistics v-if="section == 'stats'" :subSection="subSectionStat"></CimeroStatistics>
            <ChangePassword v-if="section == 'password'"></ChangePassword>
        </v-flex>
      </v-layout>
    </v-container>
</v-app>
</template>




<script>

    import AddCimaForm from '../Private/AddCimaForm';
    import CimeroEditCuentaForm from '../Private/CimeroEditCuentaForm';
    import CimeroLogrosSummary from '../CimeroLogrosSummary';
    import CimeroStatistics from '../Private/CimeroStatistics';
    import ChangePassword from '../Private/ChangePassword';

    export default {
        props: ["cimero"],
        components: {
            'AddCimaForm' : AddCimaForm,
            'CimeroEditCuentaForm' : CimeroEditCuentaForm,
            'CimeroLogrosSummary' : CimeroLogrosSummary,
            'CimeroStatistics' : CimeroStatistics,
            'ChangePassword' : ChangePassword,
        },  

        data: function() {
            return {
                section: '',
                subSectionStat: 'bar',
                addedCimas: [],
                logros: null,
            };
        },

        watch: {
            section: function(newVal,oldVal) {
                if (this.section === 'summary') this.loadSummary();
            },
        },

        methods: {
            setStat: function(type){
                this.section = 'stats';
                this.subSectionStat = type;
            },

            loadSummary: function(){
                var self = this;
                axios.get(this.baseUrl + '/ajax/userfulllogros').then(function(response){
                   self.logros = response.data;
                });
            },
        }
    }
</script>
