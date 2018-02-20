<template> 
    <div class="input-group">

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
        props: ["cima","logro"],
        data: function() {
            return {
                completed:false,
            };
        },
        computed: {
            baseLogro : function(){
                if (this.logro) return JSON.parse(this.logro);
                else return null;
            },
        },

        beforeMount: function() {
            this.userLogro = this.baseLogro;
            this.completed = this.userLogro ? true : false;
        },

        methods: {

            /**
             * Fills in a province list or empties other fields when changing a communidad input
             * @trigger Change Communidad Input
             * @params event
             * @result Triggers ajax call to get provinces or empties the other inputs
            */

            add: function(){
                event.preventDefault();
                var self = this;
                axios.post('/update-logro',{
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
                console.log(this.userLogro);
                axios.post('/update-logro',{
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
