
<template>
<div id="ranking">
    <BaseTable 
        :data="data"
        :columns="columns"
    ></BaseTable>
</div>
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
                axios.get('api/filtersranking/'+this.bringFilters).then(function(response){
                    response.data.map(function(d,i){
                        d.rank = i+1;
                         d.link = 'cimeropublicdetails/' + d.id;
                    })
                    self.data = response.data;
                });
            },

        }
    }

</script>
