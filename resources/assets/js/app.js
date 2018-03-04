
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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
      get globalReadOnlyProperty() {
        return "Can't change me!";
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


// FORMS
Vue.component('addcimaform', require('./components/AddCimaForm.vue'));
Vue.component('cimeroeditcuentaform', require('./components/CimeroEditCuentaForm.vue'));
// FORMS CHILD COMPONENTS
Vue.component('addcimainput', require('./components/AddCimaInput.vue'));
// INTERACIVE COMPONENTS
Vue.component('cimerologrossummary', require('./components/CimeroLogrosSummary.vue'));
Vue.component('cimaquickadd', require('./components/CimaQuickAdd.vue'));
// CONTAINER BUILDS
Vue.component('rankingcontainer', require('./components/RankingContainer.vue'));
Vue.component('statisticscontainer', require('./components/StatisticsContainer.vue'));
// MODAL WINDOWS
Vue.component('cimamodal', require('./components/CimaModal.vue')); /* NOT CURRENTLY USED */
// SHARED COMPONENTS
Vue.component('datatable', require('./components/DataTable.vue'));
// MAP COMPONENTS
Vue.component('mapcontainer', require('./components/MapContainer.vue'));
// COMPONENETS
Vue.component('loadingcontainer', require('./components/LoadingContainer.vue'));
Vue.component('cimaselectionlist', require('./components/CimaSelectionList.vue'));
Vue.component('cimasearch', require('./components/CimaSearch.vue'));
Vue.component('cimadetail', require('./components/CimaDetail.vue'));
//Vue.component('googlemap', require('./components/GoogleMap.vue'));

const app = new Vue({
    el: '#vuepage'
});

