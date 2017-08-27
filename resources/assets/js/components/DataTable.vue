<template> 
    
    <div class="panel-body">

        <div class="col-md-12">
            <div class="row">

                <!-- Page change -->

                <select v-if="dataObject" v-model="page">
                    <option v-show="count === 0" disabled>--</option>
                    <option v-for="n in pages" :value="n">{{n}}</option>
                </select>

                <!-- Page Size change -->

                <select v-if="dataObject" v-model="pagination">
                    <option v-show="count === 0" disabled>0</option>
                    <option v-show="count > 0">10</option>
                    <option v-if="count / 25 >= 1">25</option>
                    <option v-if="count / 50 >= 1">50</option>
                    <option v-if="count / 100 >= 1">100</option>
                </select>

                <!-- Option Filters -->

                <select v-for="(value, key) in filters" @change="filterByOption" :data-filter="key">
                    <option selected>{{key}}</option> 
                    <option v-for="option in filters[key]" :value="option">{{option}}</option>
                </select>

                <!-- Text Filters -->

                <input v-if="dataObject" placeholder="Buscar ... " @keyup="filterBySearch">

                <!-- Table -->

                <table v-if="dataObject" class="table table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th v-for="column in columns" >
                                {{column.title}}
                                <a @click="orderByAscending" :data-order="column.field">a</a>
                                <a @click="orderByDescending" :data-order="column.field">d</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-show="dataObject && count === 0"><td :colspan="columns.length" class="text-center">Nada Encontrado</td></tr>
                        <tr v-for="(row, index) in filteredData" v-if="index >= pagination * (page - 1) && index < pagination * page">
                            <td v-for="column in columns">
                                {{row[column.field]}}
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</template>



<script>
    export default {
        data: function() {
            return {
                columns: [],
                dataObject: null,
                filteredData: null,

                count:0,
                page: 1,
                pagination: 25,

                filters: null,
            };
        },
        computed: {

            pages: function () {
                return Math.ceil(this.count / this.pagination);
            }

        },

        mounted: function() {
            this.fetchData();
        },

        methods: {

            /**
             * Gets the requested data for the datatable
             * @trigger onMounted()
             * @result returns a dataobject and count
            */

            fetchData:function(){
                var self = this;

                axios.get('api/statistics/cimasbylogro').then(function(response){
                    self.dataObject = response.data.dataObject;
                    self.filteredData = response.data.dataObject;
                    self.count = response.data.dataObject.length;
                    self.columns = response.data.columns;
                    self.prepareSelectFilters(response.data.dataObject, response.data.filters);
                });
            },

            /**
             * Parses the select filters from the given inputs and data
             * @trigger fetchData() ajax promise
             * @param object data
             * @param array filterOptions
             * @result sets the select option filters in the model
            */

            prepareSelectFilters: function(data,filtersOptions){
                var self = this;

                var filters = {};
                filtersOptions.forEach(function(item){
                    filters[item] = [];
                });

                data.forEach(function(item){
                    for (var key in filters) {
                        if (filters[key].indexOf(item[key]) === -1)
                            filters[key].push(item[key]);
                    };
                });

                for (var key in filters) {
                    filters[key].sort(function(a,b){
                        if(self.stripAccents(a) < self.stripAccents(b)) return -1;
                        if(self.stripAccents(a) > self.stripAccents(b)) return 1;
                        return 0;
                    });
                };
                this.filters = filters;
            },

            

            /**
             * Filters on a search, or resets if no serach entered
             * @trigger changing the input search
             * @param event.target.value
             * @result sets the data with filtered parameters
            */

            filterBySearch:function(event){
                var self = this;

                if (event.target.value.length === 0) {
                    this.filteredData = this.dataObject;
                    this.count = this.dataObject.length;
                    return;
                }

                var filteredData;
                var searchValue = this.stripAccents(event.target.value.toLowerCase());
                filteredData = this.dataObject.filter(function(item){
                    return self.stripAccents(item.nombre.toLowerCase()).indexOf(searchValue) !== -1;
                });

                this.filteredData = filteredData;
                this.count = filteredData.length;
                this.page = 1;

            },

            /**
             * Filters on an option change
             * @trigger changing any select option filter
             * @param event (id = key, value = option)
             * @result filters the data object by the requested input
            */

            filterByOption: function(event){
                var self = this;
                this.filteredData = this.dataObject.filter(function (item) {
                    return item[event.target.dataset.filter] === event.target.value;
                });
            },

            /**
             * Sorts the data in ascending order
             * @trigger clicking any ascending button in column header
             * @param event (field = event.target.dataset.order)
             * @result orders the visible data in ascending order
            */

            orderByAscending:function(event){
                var self = this;
                var field = event.target.dataset.order;
                this.filteredData = this.filteredData.sort(function(a,b){
                    if(self.stripAccents(a[field]) > self.stripAccents(b[field])) return -1;
                    if(self.stripAccents(a[field]) < self.stripAccents(b[field])) return 1;
                    return 0;
                });

            },

            /**
             * Sorts the data in descending order
             * @trigger clicking any ascending button in column header
             * @param event (field = event.target.dataset.order)
             * @result orders the visible data in descending order
            */

            orderByDescending:function(event){
                var self = this;
                var field = event.target.dataset.order;
                this.filteredData = this.filteredData.sort(function(a,b){
                    if(self.stripAccents(a[field]) < self.stripAccents(b[field])) return -1;
                    if(self.stripAccents(a[field]) > self.stripAccents(b[field])) return 1;
                    return 0;
                });
            },

            /**
             * Strips accents from a search for filtering
             * @param string
             * @return stripped string
            */

            stripAccents:function(string){
                var accent_map = {
                    'á': 'a', 
                    'é': 'e',                     
                    'í': 'i',                    
                    'ó': 'o', 
                    'ú': 'u',
                    'ü': 'u',                      
                };

                if (typeof(string) === "number") { return string; }
                if (!string) { return ''; }
                var returnString = '';
                for (var i = 0; i < string.length; i++) {
                    returnString += accent_map[string.toLowerCase().charAt(i)] || string.toLowerCase().charAt(i);
                }
                return returnString;
            },

        }
    }
</script>
