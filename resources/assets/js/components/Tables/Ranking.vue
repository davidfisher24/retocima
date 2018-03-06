
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
                    { field: 'image', title: '', type: 'image' },
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
                        d.link = 'cimeropublicdetails/' + d.id;
                        if (d.logros_count >= 480) d.image = 'img/icons/gold.png';
                        else if (d.logros_count < 480 && d.logros_count >= 320) d.image = 'img/icons/silver.png';
                        else if (d.logros_count >= 160 && d.logros_count < 320) d.image = 'img/icons/bronze.png';
                        else d.image = '';

                    })
                    self.data = response.data;
                    self.rendered = true;
                });
            },

        }
    }

</script>
