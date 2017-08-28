<template> 
    <div class="row">
        <div class="col-md-12">
            <datatable v-if="containerloaded"></datatable>
        </div>
    </div>
</template>



<script>
    export default {
        data: function() {
            return {
                apiroute: 'api/ranking/baseranking/',
                containerloaded: false,
            };
        },
        computed: {


        },

        mounted: function() {
            console.log(this);
            this.containerloaded = true;
        },

        methods: {



        }
    }
</script>
