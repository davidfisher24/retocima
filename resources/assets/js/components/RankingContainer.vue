<template> 
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
            <datatable v-if="containerloaded"></datatable>
        </div>
    </div>
</template>



<script>
    export default {
        data: function() {
            return {
                apiroute: './api/ranking/baseranking/',
                containerloaded: false,
            };
        },
        computed: {


        },

        mounted: function() {
            this.containerloaded = true;
        },

        methods: {



        }
    }
</script>
