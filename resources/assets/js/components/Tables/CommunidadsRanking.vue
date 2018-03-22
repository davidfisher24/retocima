
<template>
<v-container>
    <v-layout>
        <v-flex>
            <BaseTable 
                :data="data"
                :columns="columns"
            ></BaseTable>
        </v-flex>
    </v-layout>
</v-container>
</div>
</template>

<script>

    import BaseTable from './BaseTable.vue';

    export default {

        components: {
            'BaseTable': BaseTable,
        },

        mounted: function() {
            this.fetchData();
        },

        data: function() {
            return {
                data: null,
                columns: [
                    { field: 'rank', title: 'Posicion' },
                    { field: 'nombre', title: 'Nombre', sortable: true },
                    { field: 'logros_count', title: 'Logros', sortable: true },
                ],
            };
        },

        methods : {

            fetchData: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/communidadsranking').then(function(response){
                    response.data.map(function(d,i){
                        d.rank = i+1;
                    })
                    self.data = response.data;
                });
            },

        }
    }

</script>
