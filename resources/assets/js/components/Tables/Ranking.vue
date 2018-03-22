
<template>
<v-app>
    <v-container>
        <v-layout>
            <v-dialog v-model="modal" fullscreen>
              <v-card>
                <CimeroDetail :id="modalId" v-if="modal"></CimeroDetail>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" flat="flat" @click.native="modal = false">Cerrar</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

            <v-flex>
                <BaseTable 
                    :data="data"
                    :columns="columns"
                    :filterOptions="{Provincia:'provinciaName'}"
                    :searchOptions="{Nombre:'fullName'}"
                    @openCimero="openCimero"
                ></BaseTable>
            </v-flex>
        </v-layout>
    </v-container>
</v-app>
</div>
</template>

<script>

    import BaseTable from './BaseTable.vue';
    import CimeroDetail from '../CimeroDetail';

    export default {

        components: {
            'BaseTable': BaseTable,
            'CimeroDetail' : CimeroDetail,
        },

        mounted: function() {
            this.fetchData();
        },

        data: function() {
            return {
                data: null,
                columns: [
                    { field: 'rank', title: 'Posicion' },
                    { field: 'image', title: 'Medalla', type: 'image' },
                    { field: 'fullName', title: 'Nombre', type:'link', url: 'link', sortable: true, event: "openCimero", eventId: "id" },
                    { field: 'provinciaName', title: 'Provincia', sortable: true },
                    { field: 'logros_count', title: 'Logros', sortable: true },
                ],
                modalId: 0,
                modal: false,
            };
        },

        methods : {

            fetchData: function(){
                var self = this;
                axios.get(this.baseUrl + 'api/ranking').then(function(response){
                    response.data.map(function(d,i){
                        d.rank = i+1;
                        d.link = self.baseUrl + '/cimeropublicdetails/' + d.id;
                        if (d.logros_count >= 480) d.image = 'img/icons/gold.png';
                        else if (d.logros_count < 480 && d.logros_count >= 320) d.image = 'img/icons/silver.png';
                        else if (d.logros_count >= 160 && d.logros_count < 320) d.image = 'img/icons/bronze.png';
                        else d.image = '';

                    })
                    self.data = response.data;
                });
            },

            openCimero:function(id){
                this.modalId = id;
                this.modal = true;
            }

        }
    }

</script>
