
<template>
<div id="communidadsranking">
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
                axios.get('api/communidadsranking').then(function(response){
                    response.data.map(function(d,i){
                        d.rank = i+1;
                    })
                    self.data = response.data;
                });
            },

        }
    }

</script>
