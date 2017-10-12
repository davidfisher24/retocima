<template> 
    <div class="row">
        <h1 v-if="cima">{{cima.nombre}}</h1>
    </div>
</template>



<script>
    export default {
        data: function() {
            return {
            };
        },

        props: ['cima'] ,

        computed: {


        },

        mounted: function() {
        },

        methods: {



        }
    }
</script>
