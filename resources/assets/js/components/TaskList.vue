<template> 
    <div class="row">
        <div class="col-md-12">
            <form class="form" v-on:submit.prevent>
                <div class="form-control" v-for="n in requestedInputs">
                    <task ref="task"></task>
                </div>
                
                <button class="btn btn-default" @click="submitLogros()">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                requestedInputs: 10,
                userLogros: [],
                communidads: [],
            };
        },
        mounted: function() {
            this.fetchUserLogros();
            this.fetchCommunidads();
        },
        methods: {
            fetchUserLogros: function(){
                var self = this;
                axios.get('api/userlogros').then(function(response){
                    self.userLogros = response.data;
                    self.$refs.task.forEach(function(component){
                        component.setUserLogrosFromParent(response.data);
                    });
                });
            },
            fetchCommunidads: function(){
                var self = this;
                axios.get('api/communidads').then(function(response){
                    self.communidads = response.data;
                    self.$refs.task.forEach(function(component){
                        component.setCommunidadsFromParent(response.data);
                    });
                });
            },
            submitLogros: function(){ 
                this.$refs.task.forEach(function(component){
                    if(component.completed) {
                        console.log("Prepare to add cima " + component.selectedCima);
                    }
                });         
            }
        }
    }
</script>
