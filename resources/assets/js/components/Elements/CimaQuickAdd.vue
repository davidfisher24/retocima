<template> 
    <div class="input-group" v-if="mount">

        <div v-if="completed === true">
            <h3>Logro Completed!</h3><br>
            <a @click="remove($event)">Quitar</a>
        </div>
        <div v-if="completed === false">
            <button class="btn btn-primary" @click="add($event)">Añadir Logro</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["cima"],
        data: function() {
            return {
                mount: false,
                completed:false,
            };
        },

        mounted: function() {
            this.checkAndMount();
        },

        watch: { 
            cima: function(newVal, oldVal) {
                this.mount = false;
                this.completed = false;
                this.checkAndMount();
            }
        },


        methods: {

            checkAndMount: function(){
                var self = this;
                axios.get(self.baseUrl + '/ajax/checklogro/'+this.cima.id).then(function(response){
                    if (response.data !== 'Unauthorized') {
                        self.mount = true;
                        self.userLogro = response.data;
                        self.completed = self.userLogro ? true : false;
                    }
                });
            },

            /**
             * Fills in a province list or empties other fields when changing a communidad input
             * @trigger Change Communidad Input
             * @params event
             * @result Triggers ajax call to get provinces or empties the other inputs
            */

            add: function(){
                event.preventDefault();
                var self = this;
                axios.post(this.baseUrl + '/ajax/update-logro',{
                    action: 'add',
                    logro: this.userLogro,
                    cima: this.cima,
                }).then(function(response){
                    if (response.data) {
                        self.userLogro = response.data;
                        self.completed = true;
                    }
                });
            },

            remove: function(event){
                event.preventDefault();
                var self = this;
                axios.post(this.baseUrl + '/ajax/update-logro',{
                    action: 'remove',
                    logro: JSON.stringify(this.userLogro),
                }).then(function(response){
                    if (!response.data) {
                        self.userLogro = null;
                        self.completed = false;
                    }
                });
            },


        }
    }

</script>
