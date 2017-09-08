<template> 
    
    <div class="panel-body">

        <div class="col-md-12">
            <div v-if="dataObject" class="row">

                <!-- HEADER-->
                <div class="row">
                    <!-- Page Size change -->
                    <select v-model="pagination">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>

                    <!-- Option Filters -->
                    <select v-for="(value, key) in filters" @change="filterByOption" :data-filter="key">
                        <option selected>Todos</option> 
                        <option v-for="option in filters[key]" :value="option">{{option}}</option>
                    </select>

                    <!-- Text Filters -->
                    <input v-for="value in searches" placeholder="Buscar ..." @keyup="filterBySearch" :data-search="value">
                </div>

                <!-- TABLE -->
                <table class="table table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th v-for="column in columns" >
                                {{column.title}}
                                <a @click="setOrderingPreference" :data-field="column.field" data-order="asc">a</a>
                                <a @click="setOrderingPreference" :data-field="column.field" data-order="desc">d</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-show="count === 0"><td :colspan="columns.length" class="text-center">Nada Encontrado</td></tr>
                        <tr v-for="(row, index) in filteredData" v-if="index >= pagination * (page - 1) && index < pagination * page">
                            <td v-for="column in columns">
                                {{row[column.field]}}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- FOOTER -->
                <div class="row">
                    <div class="col-md-6">
                        <p>Mostrando {{pagination * (page - 1) + 1}} a {{pagination * page}} de {{count}} filas</p>
                    </div>
                    <div class="col-md-6 text-right">
                    <!-- Page change -->
                        <ul class="list-inline">
                            <li v-if="page !== 1" @click="previousPage">Prev</li>
                            <li v-for="n in pages" v-if="visiblePages.indexOf(n) !== -1" :data-page="n" @click="changePage">{{n}}</li>
                            <li v-if="page !== pages.length && pages !== 1" @click="nextPage">Next</li>
                        </ul>
                    </div>
                </div>
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
                searches: null,

                currentFilters: [], // Array of objects {field: filter}
                currentSearches: [], // Array of objects {field: search}
                currentOrdering: [], // Array [field,order]
            };
        },
        computed: {

            /*
            * Calculates the number of pages by divding total count by pagination choice
            */

            pages: function () {
                var pages = Math.ceil(this.count / this.pagination);
                return pages > 0 ? pages : 1;
            },

            /*
            * Calculates the pages to show in the page options
            */

            visiblePages: function() {
                var visiblePages = [];
                var current = this.page;
                var number = this.pages;
                var maximumLinks = 4;
                while(current < number && visiblePages.length < maximumLinks){
                    visiblePages.push(current + 1);
                    current++;
                }
                return visiblePages;
            },  

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
                //'api/statistics/cimasbylogro'

                axios.get(this.$parent.apiroute).then(function(response){
                    self.dataObject = response.data.dataObject;
                    self.filteredData = response.data.dataObject;
                    self.count = response.data.dataObject.length;
                    self.columns = response.data.columns;
                    self.searches = response.data.searches;
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
                    self.currentFilters[item] = "Todos";
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
             * Decreases page size by one
             * @trigger click a page number
             * @result sets the page number minus 1
            */

            nextPage:function(){
                this.page = this.page + 1;
            },

            /**
             * Increases page size by one
             * @trigger click a page number
             * @result sets the page number plus 1
            */

            previousPage:function(){
                this.page = this.page - 1;
            },

            /**
             * Goes to a specfic page
             * @trigger click a page number
             * @param event.target.dataset.page
             * @result sets the page number to the number clicked
            */

            changePage:function(event){
                this.page = parseInt(event.target.dataset.page);
            },


            /**
             * Stores a current search filter
             * @trigger changing an input search
             * @param event.target.value
             * @result deletes or sets the filter in the currentSearches object and calls the filterTable function
            */

            filterBySearch:function(event){
                if (!event.target.value) {
                    delete this.currentSearches[event.target.dataset.search];
                }

                this.currentSearches[event.target.dataset.search] = event.target.value;
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
             * @param event.target {field: dataset.field, order: dataset.order}
             * @result Sets the ordering option in the currentordering array and calls the filterTable function
            */

            setOrderingPreference:function(event){
                this.currentOrdering = [event.target.dataset.field,event.target.dataset.order];
                this.prepareFilteredTable();
            },

            /**
             * Prepares the dataobject into the filteredData to be shown
             * @trigger any filter or change function
            */

            prepareFilteredTable:function(){
                //currentFilters: [], // Array of objects {field: filter}
                //currentSearches: [], // Array of objects {field: search}
                //currentOrdering: [], // Array [field,order]

                var self = this;

                var filteredData = this.dataObject.filter(function(item){
                    var filterOK = false;
                    var searchOK = false;

                    var searchesMet = 0;
                    var filtersMet = 0;

                    Object.keys(self.currentSearches).forEach(function(key){
                        if (self.stripAccents(item[key].toLowerCase()).indexOf(self.stripAccents(self.currentSearches[key].toLowerCase())) !== -1) {
                            searchesMet++;
                        }
                    });

                    
                    Object.keys(self.currentFilters).forEach(function(key){
                        if (self.currentFilters[key] === "Todos") {
                        filtersMet++;
                        } else {
                            if (item[key] === self.currentFilters[key]) {
                                filtersMet++;
                            }
                        }
                    });

                    if (filtersMet === Object.keys(self.currentFilters).length) filterOK = true;
                    if (searchesMet === Object.keys(self.currentSearches).length) searchOK = true;

                    return searchOK === true && filterOK === true;
                });

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

            /**
             * Sorts data in ascending order
             * @ param data dataobject
             * @ param string field to search on
             * @ return sorted data object
            */

            sortDataByAscending:function(data,field){
                var self = this;

                 return data.sort(function(a,b){
                    if(self.stripAccents(a[field]) < self.stripAccents(b[field])) return -1;
                    if(self.stripAccents(a[field]) > self.stripAccents(b[field])) return 1;
                    return 0;
                });
            },

            /**
             * Sorts data in descending order
             * @ param data dataobject
             * @ param string field to search on
             * @ return sorted data object
            */

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
