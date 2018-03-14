<template> 
    <div class="row">
        <div class="col-md-4 col-xs-4 col-sm-4 col-xl-4 col-lg-4">
            <li class="select-option" @click="section = 'edit'"><a>Editar cuenta</a></li>
            <li class="select-option" @click="section = 'summary'"><a>Resumen Logros</a></li>
            <li class="select-option" @click="section = 'add'"><a>Anadir Cima</a></li>
            <li class="select-option" @click="section = 'stats'"><a>Estadistica</a></li>
                <div  v-if="section == 'stats'">
                    <p @click="subSectionStat = 'bar'" class="select-option">Logros por communidad</p>
                    <p @click="subSectionStat = 'pie'" class="select-option">Logros por provincia</p>
                    <p @click="subSectionStat = 'spline'" class="select-option">Altitud de mis cimas</p>
                </div>
            <li class="select-option" @click="section = 'password'"><a>Cambiar Contrasena</a></li>
        </div>
        <div class="col-md-8 col-xs-8 col-sm-8 col-xl-8 col-lg-8">
            <AddCimaForm v-if="section == 'add'"></AddCimaForm>
            <CimeroEditCuentaForm v-if="section == 'edit'"></CimeroEditCuentaForm>
            <CimeroLogrosSummary v-if="section == 'summary'"></CimeroLogrosSummary>
            <CimeroStatistics v-if="section == 'stats'" :subSection="subSectionStat"></CimeroStatistics>
            <ChangePassword v-if="section == 'password'"></ChangePassword>
        </div>

    </div>
</template>



<script>

    import AddCimaForm from '../Private/AddCimaForm';
    import CimeroEditCuentaForm from '../Private/CimeroEditCuentaForm';
    import CimeroLogrosSummary from '../Private/CimeroLogrosSummary';
    import CimeroStatistics from '../Private/CimeroStatistics';
    import ChangePassword from '../Private/ChangePassword';

    export default {
        props: ["cimero"],
        components: {
            'AddCimaForm' : AddCimaForm,
            'CimeroEditCuentaForm' : CimeroEditCuentaForm,
            'CimeroLogrosSummary' : CimeroLogrosSummary,
            'CimeroStatistics' : CimeroStatistics,
            'ChangePassword' : ChangePassword,
        },  

        data: function() {
            return {
                section: '',
                subSectionStat: 'bar',
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
