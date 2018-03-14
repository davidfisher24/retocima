<template> 
    <div class="row">
        Welcome {{cimero.nombre}}
        <a @click="section = 'edit'">Editar cuenta</a>
        <a @click="section = 'summary'">Resumen Logros</a>
        <a @click="section = 'add'">Anadir Cima</a>
        <a @click="section = 'stats'">Estadistica</a>
        <AddCimaForm v-if="section == 'add'"></AddCimaForm>
        <CimeroEditCuentaForm v-if="section == 'edit'"></CimeroEditCuentaForm>
        <CimeroLogrosSummary v-if="section == 'summary'"></CimeroLogrosSummary>
        <CimeroStatistics v-if="section == 'stats'"></CimeroStatistics>
    </div>
</template>



<script>

    import AddCimaForm from '../Private/AddCimaForm';
    import CimeroEditCuentaForm from '../Private/CimeroEditCuentaForm';
    import CimeroLogrosSummary from '../Private/CimeroLogrosSummary';
    import CimeroStatistics from '../Private/CimeroStatistics';

    export default {
        props: ["cimero"],
        components: {
            'AddCimaForm' : AddCimaForm,
            'CimeroEditCuentaForm' : CimeroEditCuentaForm,
            'CimeroLogrosSummary' : CimeroLogrosSummary,
            'CimeroStatistics' : CimeroStatistics,
        },  

        data: function() {
            return {
                section: '',
                addedCimas: [],
            };
        },

        computed: {

        },

        mounted: function() {
        },

        methods: {
     
        }
    }
</script>
