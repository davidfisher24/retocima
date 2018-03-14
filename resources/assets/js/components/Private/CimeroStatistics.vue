<template> 
    <section class="charts">
        <loadingcontainer v-if="loading"></loadingcontainer>
        <LogrosPorCommunidadBar v-if="chart =='comm-bar' && !loading" :data="data"></LogrosPorCommunidadBar>
        <CimasPorAltitudSpline v-if="chart =='altitud-spline' && !loading" :data="data"></CimasPorAltitudSpline>
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
      props: ['subSection'],
      data() {
        return {
          data: null,
          chart: '',
          loading: true,
        }
      },

      watch: {
        subSection: function () {
          this.setChart();
        }
      },

      mounted: function(){
          this.setChart();
      },

      methods: {

        setChart: function(){
          this.loading = true;
          if (this.subSection === 'bar') this.loadBar();
          else if (this.subSection === 'spline') this.loadSpline();
        },

        loadBar(){
            var self = this;
            axios.get(self.baseUrl + '/ajax/logrosbycommunidad').then(function(response){
              self.data = response.data;
              self.chart = 'comm-bar'
              self.loading = false;
            });

        },

        loadSpline(){
          var self = this;
            axios.get(self.baseUrl + '/ajax/logrosbyaltitud').then(function(response){
              self.data = response.data;
              self.chart = 'altitud-spline';
              self.loading = false;
            });
        }
      }
    }

</script>
