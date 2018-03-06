
<template>
<div id="ranking">
    <BaseTable 
        :data="data"
        :columns="columns"
        :filterOptions="{Provincia:'provinciaName'}"
        :searchOptions="{nombre:'fullName'}"
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
                    { field: 'rank', title: '' },
                    //{ field: 'image', title: '', type: 'image' },
                    { field: 'fullName', title: 'Nombre', type:'link', url: 'link' },
                    { field: 'provinciaName', title: 'Provincia' },
                    { field: 'logros_count', title: 'Logros' },
                ],
            };
        },

        methods : {

            fetchData: function(){
                var self = this;
                axios.get('api/ranking').then(function(response){
                    response.data.map(function(d,i){
                        d.rank = i+1;
                        d.image = 'img/icons/silver.png';
                        d.link = 'cimeropublicdetails/' + d.id;
                    })
                    self.data = response.data;
                    self.rendered = true;
                });
            },

        }
    }

</script>
