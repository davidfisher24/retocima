
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
</template>

<script>

    import BaseTable from './BaseTable.vue';

    export default {

        components: {
            'BaseTable': BaseTable,
        },

        props: ['bringFilters'],

        mounted: function() {
            this.fetchData();
        },

        data: function() {
            return {
                data: null,
                columns: [
                    { field: 'rank', title: 'Posicion' },
                    { field: 'fullName', title: 'Nombre', type:'link', url: 'link', sortable: true },
                    { field: 'logros_count', title: 'Logros', sortable: true },
                ],
            };
        },

        methods : {

            fetchData: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/filtersranking/'+this.bringFilters).then(function(response){
                    response.data.map(function(d,i){
                        d.rank = i+1;
                        d.link = self.baseUrl + '/cimeropublicdetails/' + d.id;
                    })
                    self.data = response.data;
                });
            },

        }
    }

</script>
