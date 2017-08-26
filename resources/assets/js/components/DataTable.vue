<template> 
    
    <div class="panel-body">
        <div class="col-md-12">
            <div class="row">
                <table class="table table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th v-for="column in columns" >
                                {{column.title}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in data" v-if="index < 25">
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
                data: [],
            };
        },
        props: [],

        mounted: function() {
            this.fetchData();
        },

        methods: {

            /**
             * Gets the unique communidads from the logros
             * @trigger onMounted()
             * @params references the passed logros reference
             * @result builds an array of distinct communidads
            */

            fetchData:function(){
                var self = this;
                axios.get('api/ranking').then(function(response){
                    self.data = response.data;
                });
            },

        }
    }
</script>
