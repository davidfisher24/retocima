<template> 
      <vue-highcharts :options="options" ref="barChart"></vue-highcharts>
</template>



<script>
    import VueHighcharts from 'vue2-highcharts';
    const baseOptions = {
      chart: {
        type: 'column',
      },
      title: {
        text: 'Logros por communidad',
      },
      xAxis: {
        categories: [],
        title: {
          text: null,
        },
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif',
            }
        }
      },
      yAxis: {
        min: 0,
        max: 0,
        title: {
          text: 'Ascensiones',
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
        var barChart = this.$refs.barChart;
        var series = {
            name: 'Ascensiones',
            data: [],
        };
        var categories = [];
        var max = 0;
        for (var key in this.data) {
            series.data.push(this.data[key].count)
            categories.push(this.data[key].nombre);
            max = this.data[key].count > max ? this.data[key].count : max;
        }
        this.options.yAxis.max = max;
        this.options.xAxis.categories = categories;
        barChart.mergeOption(this.options);
        barChart.addSeries(series);
      },
    }

</script>
