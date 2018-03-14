<template> 
    <section class="charts">
        <LogrosPorCommunidadBar v-if="loadChart" :data="data"></LogrosPorCommunidadBar>
    </section>
</template>



<script>
    import LogrosPorCommunidadBar from '../Charts/LogrosPorCommunidadBar';

    export default {
      components: {
        'LogrosPorCommunidadBar' : LogrosPorCommunidadBar,
      },
      data() {
        return {
          loadChart: false,
          data: null,
        }
      },

      mounted: function(){
            this.load();
        },

        methods: {
          load(){
              var self = this;
              let barChart = this.$refs.barChart;
              axios.get(self.baseUrl + '/ajax/logrosbycommunidad').then(function(response){
                self.data = response.data;
                self.loadChart = true;

              });
          }
        }
    }

</script>
