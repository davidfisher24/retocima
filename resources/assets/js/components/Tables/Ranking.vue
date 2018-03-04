
<template>
<div id="ranking">
    <!--<v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table>-->
    <v-server-table url="" :columns="columns" :options="options" :perPage="25">
    </v-server-table>
</div>
</template>

<script>
    import {ServerTable, ClientTable, Event} from 'vue-tables-2';
    var options = {
        perPage:25,
    }
    Vue.use(ServerTable, [options = options]);
    //Vue.use(ServerTable, [options = options], [useVuex = false], [theme = 'bootstrap3'], [template = 'default']);

    export default {
        data: function() {
            return {
                el: "#ranking",
                columns: ['rank','id','fullname', 'logros_count'],
                options: {
    
                    headings: {
                        rank: '',
                        id: 'No. Cimero',
                        nombre: 'Nombre',
                    },
                    requestFunction: function (data) {
                        return axios.get("/api/ranking")
                        .catch(function (e) {
                            this.dispatch('error', e);
                        }.bind(this));
                    },

                    responseAdapter: function(resp){
                        var data = resp.data.map(function(d,i){
                            d.logros_count = Math.floor(Math.random() * 1000);
                            d.rank = i+1;
                            return d;
                        })
                        return { data: data, count: resp.data.length }
                    }


                }
            };
        },
    }

</script>
