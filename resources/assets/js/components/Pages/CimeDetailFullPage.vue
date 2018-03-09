<template> 

   <div class="panel-body container-fluid">
        <div class="row" v-if="cima">
            <cimadetail v-if="cima"  class="item" :cima="cima"></cimadetail>
        </div>
    </div>


</template>


<script>

    export default {
        props: ["id"],
        data: function() {
            return {
                cima: null,
            };
        },

        mounted:function(){
            var self = this;
            axios.get(this.baseUrl + '/api/cima/'+this.id).then(function(response){
                response.data.communidad = response.data.communidad.nombre;
                response.data.provincia = response.data.provincia.nombre;
                self.cima = response.data;
            });
        },


    }

</script>
