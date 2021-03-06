
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
const config = require('./env').default;
window._ = require('lodash');
window.axios = require('axios');
require('./bootstrap');

window.Vue = require('vue');
window.HighCharts = require('highcharts');

Vue.use(require('vue2-google-maps'), {
  load: {
    key: 'AIzaSyAtqWsq5Ai3GYv6dSa6311tZiYKlbYT4mw',
  }
})

window.Vuetify = require('vuetify');
require('vuetify/dist/vuetify.min.css');
Vue.use(Vuetify);

Vue.mixin({
  data: function() {
    return {
      get baseUrl() {
        return config.baseUrl;
      }
    }
  }
})

const theme = {
  primary: '#1976D2', 
  secondary: '#75D8E9', 
  tercary: '#424242',
  accent: '#E65100',
  error: '#FF5252', 
  info: '#2196F3', 
  success: '#4CAF50',
  warning: '#FFC107', 
  text: '#fff'
};



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// TABLES

// PAGE LAYOUTS






// ELEMENTS





Vue.component('cimaselectionlist', require('./Listado/CimaSelectionList.vue'));
Vue.component('homepage', require('./Home/Home.vue'));
Vue.component('rankingtable', require('./Ranking/Ranking.vue'));
Vue.component('statisticscontainer', require('./Statistics/StatisticsContainer.vue'));
Vue.component('dashboard', require('./Cuenta/Dashboard.vue'));
Vue.component('googlemap', require('./Map/MapContainer.vue'));
Vue.component('patanegracontainer', require('./PataNegra/PataNegraContainer.vue'));


Vue.component('cima', require('./Pages/Cima.vue'));
Vue.component('cimero', require('./Pages/Cimero.vue'));

Vue.component('loadingcontainer', require('./components/LoadingContainer.vue'));
Vue.component('Flag', require('./components/Flag.vue'))
const app = new Vue({
    el: '#vuepage',
    created() {
       this.$vuetify.theme = theme
    }
});

