<template> 
    
    <div class="panel-body">
        <div class="col-md-12">
            <div class="row">

                <select v-if="dataObject" v-model="page">
                    <option v-show="count === 0" disabled>--</option>
                    <option v-for="n in pages" :value="n">{{n}}</option>
                </select>

                <select v-if="dataObject" v-model="pagination">
                    <option v-show="count === 0" disabled>--</option>
                    <option v-show="count > 0">10</option>
                    <option v-if="count / 25 >= 1">25</option>
                    <option v-if="count / 50 >= 1">50</option>
                    <option v-if="count / 100 >= 1">100</option>
                </select>

                <input v-if="dataObject" placeholder="Buscar ... " @keyup="filterBySearch">

                <table class="table table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th v-for="column in columns" >
                                {{column.title}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-show="dataObject && count === 0" :colspan="3"><p class="text-center">Nada Encontrado</p></tr>
                        <tr v-for="(row, index) in filteredData" v-if="index >= pagination * (page - 1) && index < (pagination * (page - 1)) + pagination">
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
                columns: [
                    {
                        field: 'id',
                        title: 'No. Cimero',
                    },
                    {
                        field: 'nombre',
                        title: 'Nombre'
                    },
                    {
                        field: 'logros_count',
                        title: 'Logros Count'
                    }
                ],
                dataObject: null,
                filteredData: null,

                count:0,
                page: 1,
                pagination: 25,

            };
        },
        computed: {

            pages: function () {
                return Math.round(this.count / this.pagination);
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
                axios.get('api/ranking').then(function(response){
                    self.dataObject = response.data;
                    self.filteredData = response.data;
                    self.count = response.data.length;
                });
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

                if (!string) { return ''; }
                var returnString = '';
                for (var i = 0; i < string.length; i++) {
                    returnString += accent_map[string.charAt(i)] || string.charAt(i);
                }
                return returnString;
            }

        }
    }
</script>
