
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.HighCharts = require('highcharts');
 
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// FORMS
Vue.component('addcimaform', require('./components/AddCimaForm.vue'));
Vue.component('cimeroeditcuentaform', require('./components/CimeroEditCuentaForm.vue'));
// FORMS CHILD COMPONENTS
Vue.component('addcimainput', require('./components/AddCimaInput.vue'));
// INTERACIVE COMPONENTS
Vue.component('cimerologrossummary', require('./components/CimeroLogrosSummary.vue'));
// CONTAINER BUILDS
Vue.component('rankingcontainer', require('./components/RankingContainer.vue'));
Vue.component('statisticscontainer', require('./components/StatisticsContainer.vue'));
// MODAL WINDOWS
Vue.component('cimamodal', require('./components/CimaModal.vue')); /* NOT CURRENTLY USED */
// SHARED COMPONENTS
Vue.component('datatable', require('./components/DataTable.vue'));
// MAP COMPONENTS
Vue.component('mapcontainer', require('./components/MapContainer.vue'));


const app = new Vue({
    el: '#vuepage'
});

