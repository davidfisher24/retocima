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
                    <option selected>Todos</option> 
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

                currentFilters: [], // Array of objects {field: filter}
                currentSearches: [], // Array of objects {field: search}
                currentOrdering: [], // Array [field,order]
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
             * Stores a current search filter
             * @trigger changing an input search
             * @param event.target.value
             * @result deletes or sets the filter in the currentSearches object and calls the filterTable function
            */

            filterBySearch:function(event){
                if (!event.target.value) {
                    delete this.currentSearches.nombre;
                }

                this.currentSearches.nombre = event.target.value;
                this.prepareFilteredTable();
            },

            /**
             * Stores a current option filter
             * @trigger changing an input select filter
             * @param event.target.value
             * @result deletes or sets the filter in the currentFilters object and calls the filterTable function
            */

            filterByOption: function(event){
                if (!event.target.value || event.target.value === "") {
                    delete this.currentFilters[event.target.dataset.filter];
                    return
                }

                this.currentFilters[event.target.dataset.filter] = event.target.value;
                this.prepareFilteredTable();

            },

            /**
             * Stores a current ordering filter
             * @trigger clicking a table header order icon
             * @param event.target.value
             * @result deletes or sets the filter in the currentFilters object and calls the filterTable function
            */

            orderByAscending:function(event){
                this.currentOrdering = [event.target.dataset.order,"asc"];
                this.prepareFilteredTable();

                /*var self = this;
                var field = event.target.dataset.order;
                this.filteredData = this.filteredData.sort(function(a,b){
                    if(self.stripAccents(a[field]) > self.stripAccents(b[field])) return -1;
                    if(self.stripAccents(a[field]) < self.stripAccents(b[field])) return 1;
                    return 0;
                });*/

            },

            /**
             * Sorts the data in descending order
             * @trigger clicking any ascending button in column header
             * @param event (field = event.target.dataset.order)
             * @result orders the visible data in descending order
            */

            orderByDescending:function(event){
                this.currentOrdering = [event.target.dataset.order,"desc"];
                this.prepareFilteredTable();

                /*var self = this;
                var field = event.target.dataset.order;
                this.filteredData = this.filteredData.sort(function(a,b){
                    if(self.stripAccents(a[field]) < self.stripAccents(b[field])) return -1;
                    if(self.stripAccents(a[field]) > self.stripAccents(b[field])) return 1;
                    return 0;
                });*/
            },

            prepareFilteredTable:function(){
                //currentFilters: [], // Array of objects {field: filter}
                //currentSearches: [], // Array of objects {field: search}
                //currentOrdering: [], // Array [field,order]

                var self = this;

                var filteredData = this.dataObject.filter(function(item){
                    var filterOK = false;
                    var searchOK = false;

                    if (!self.currentSearches.nombre) {
                        searchOK = true;
                    } else {
                        if (self.currentSearches.nombre && self.stripAccents(item.nombre.toLowerCase()).indexOf(self.stripAccents(self.currentSearches.nombre.toLowerCase())) !== -1) {
                            searchOK = true;
                        }
                    }

                    if (self.currentFilters.provincia === "Todos") {
                        filterOK = true;
                    } else {
                        if (item.provincia === self.currentFilters.provincia) {
                            filterOK = true;
                        }
                    }
                    
                    return searchOK === true && filterOK === true;
                });

                console.log(self.currentOrdering[1]);
                if (self.currentOrdering.length > 0 && self.currentOrdering[1] === 'asc') {
                   var filteredAndSortedData = self.sortDataByAscending(filteredData,self.currentOrdering[0]); 
                } else if (self.currentOrdering.length > 0 && self.currentOrdering[1] === 'desc') {
                    var filteredAndSortedData = self.sortDataByDescending(filteredData,self.currentOrdering[0]); 
                } else {
                    var filteredAndSortedData = self.sortDataByAscending(filteredData,'ranking');
                }

                this.filteredData = filteredAndSortedData;
                this.count = filteredAndSortedData.length;
                this.page = 1;
            },

            sortDataByAscending:function(data,field){
                var self = this;

                 return data.sort(function(a,b){
                    if(self.stripAccents(a[field]) < self.stripAccents(b[field])) return -1;
                    if(self.stripAccents(a[field]) > self.stripAccents(b[field])) return 1;
                    return 0;
                });
            },

            sortDataByDescending:function(data,field){
                var self = this;

                 return data.sort(function(a,b){
                    if(self.stripAccents(a[field]) > self.stripAccents(b[field])) return -1;
                    if(self.stripAccents(a[field]) < self.stripAccents(b[field])) return 1;
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
