
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
const config = require('./env').default;
require('./bootstrap');
window.Vue = require('vue');
window.HighCharts = require('highcharts');
Vue.use(require('vue2-google-maps'), {
  load: {
    key: 'AIzaSyAtqWsq5Ai3GYv6dSa6311tZiYKlbYT4mw',
  }
})

Vue.mixin({
  data: function() {
    return {
      get baseUrl() {
        return config.baseUrl;
      }
    }
  }
})

//Vue.component('vuedrawer',require('vue-drawer'));
//Vue.directive('touch',require('vue-touch'));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// CAROUSELS
Vue.component('homepagecarousel', require('./components/Carousels/CarouselHomePage.vue'));
// TABLES
Vue.component('rankingtable', require('./components/Tables/Ranking.vue'));
// PAGE LAYOUTS
Vue.component('statisticscontainer', require('./components/Pages/StatisticsContainer.vue'));
Vue.component('patanegracontainer', require('./components/Pages/PataNegraContainer.vue'));
Vue.component('cimaselectionlist', require('./components/Pages/CimaSelectionList.vue'));
Vue.component('cimadetailfullpage', require('./components/Pages/CimeDetailFullPage.vue'));
// MAPS
Vue.component('googlemap', require('./components/Maps/GoogleMap.vue'));
// ELEMENTS
Vue.component('loadingcontainer', require('./components/Elements/LoadingContainer.vue'));
Vue.component('cimaquickadd', require('./components/Elements/CimaQuickAdd.vue'));


// FORMS
Vue.component('addcimaform', require('./components/AddCimaForm.vue'));
Vue.component('cimeroeditcuentaform', require('./components/CimeroEditCuentaForm.vue'));
// FORMS CHILD COMPONENTS
Vue.component('addcimainput', require('./components/AddCimaInput.vue'));
// INTERACIVE COMPONENTS
Vue.component('cimerologrossummary', require('./components/CimeroLogrosSummary.vue'));
Vue.component('cimadetail', require('./components/CimaDetail.vue'));


const app = new Vue({
    el: '#vuepage'
});

