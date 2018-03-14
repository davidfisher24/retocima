<template> 
      <vue-highcharts :options="options" ref="pieChart"></vue-highcharts>
</template>



<script>
    import VueHighcharts from 'vue2-highcharts';
    const baseOptions = {
      chart: {
        type: 'pie',
        options3d: {
          enabled: true,
          alpha: 45,
          beta: 0,
        },
      }, 
      title: {
        text: 'Logros por provincia',
      },
      pie: {
        allowPointSelect: true,
        cursor: "pointer",
        depth: 35,
        dataLabels: {
          enabled: true,
          format: "{point.name}"
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
        var pieChart = this.$refs.pieChart;
        var series = {
            name: 'Ascensiones',
            type: "pie",
            data: [],
        };
        for (var key in this.data) {
            series.data.push({
              name: this.data[key].nombre,
              y: this.data[key].count
            })
        }
        pieChart.mergeOption(this.options);
        pieChart.addSeries(series);
      },
    }

</script>
