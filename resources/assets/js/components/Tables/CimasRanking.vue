
<template>
<div id="cimasranking">
    <BaseTable 
        :data="data"
        :columns="columns"
        :filterOptions="{Provincia:'provinciaName'}"
        :searchOptions="{Nombre:'fullName'}"
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
                    { field: 'nombre', title: 'Nombre', type:'link', url: 'link', sortable: true },
                    { field: 'provinciaName', title: 'Provincia', sortable: true },
                    { field: 'logros_count', title: 'Logros', sortable: true },
                ],
            };
        },

        methods : {

            fetchData: function(){
                var self = this;
                axios.get('api/cimasranking').then(function(response){
                    response.data.map(function(d,i){
                        d.rank = i+1;
                        d.link = 'detallescima/' + d.id;
                    })
                    self.data = response.data;
                });
            },

        }
    }

</script>
