<template> 
      <vue-highcharts :options="options" ref="splineChart"></vue-highcharts>
</template>



<script>
    import VueHighcharts from 'vue2-highcharts';
    const baseOptions = {
      chart: {
        type: 'spline',
      },
      title: {
        text: 'Logros por Altitud',
      },
      xAxis: {
        categories: [],
        title: {
          text: null,
        },
        labels: false 

      },
      yAxis: {
        allowDecimals: false,
        min: 0,
        max: 0,
        title: {
          text: 'Altitud',
        },
      },
      plotOptions: {
        legend: {
            enabled:false
        },
        column: {
            showInLegends: false,
        }
      },
      legend: {
        enabled: false,
      },
      credits: {
        enabled: false,
      },
    }

    export default {
      components: {
        VueHighcharts,
      },

      props: ["data"],

      data() {
        return {
          options: baseOptions,
        }
      },

      mounted:function(){
        var splineChart = this.$refs.splineChart;
        var series = {
            name: 'Altitud',
            data: [],
        };
        var categories = [];
        var max = 0;
        for (var key in this.data) {
            series.data.push(this.data[key].altitud)
            categories.push(this.data[key].nombre);
            max = this.data[key].altitud > max ? this.data[key].altitud : max;
        }
        this.options.yAxis.max = max;
        this.options.xAxis.categories = categories;
        splineChart.mergeOption(this.options);
        splineChart.addSeries(series);
      },
    }

</script>
