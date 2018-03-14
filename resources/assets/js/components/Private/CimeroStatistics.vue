<template> 
    <section class="charts">
        <LogrosPorCommunidadBar v-if="chart =='comm-bar'" :data="data"></LogrosPorCommunidadBar>
        <CimasPorAltitudSpline v-if="chart =='altitud-spline'" :data="data"></CimasPorAltitudSpline>
    </section>
</template>



<script>
    import LogrosPorCommunidadBar from '../Charts/LogrosPorCommunidadBar';
    import CimasPorAltitudSpline from '../Charts/CimasPorAltitudSpline';

    export default {
      components: {
        'LogrosPorCommunidadBar' : LogrosPorCommunidadBar,
        'CimasPorAltitudSpline' : CimasPorAltitudSpline,
      },
      data() {
        return {
          data: null,
          chart: '',
        }
      },

      mounted: function(){
            this.loadSpline();
        },

        methods: {
          loadBar(){
              var self = this;
              axios.get(self.baseUrl + '/ajax/logrosbycommunidad').then(function(response){
                self.data = response.data;
                self.chart = 'comm-bar'
              });

          },

          loadSpline(){
            var self = this;
              axios.get(self.baseUrl + '/ajax/logrosbyaltitud').then(function(response){
                self.data = response.data;
                self.chart = 'altitud-spline'
              });
          }
        }
    }

</script>
