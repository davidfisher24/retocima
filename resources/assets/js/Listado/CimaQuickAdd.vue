
<template>
  <div class="text-xs-center" v-if="mount">
    <v-btn fab dark large color="indigo" v-if="completed === false && !loading" fixed bottom right @click="add($event)">
      <!--<v-icon dark>add</v-icon>-->
      Añadir
    </v-btn>
    <v-btn fab dark large color="cyan" v-if="completed === true && !loading" fixed bottom right @click="remove($event)">
      <!--<v-icon dark>edit</v-icon>-->
      Hecho
    </v-btn>
    <v-btn fab dark large color="indigo" v-if="loading" fixed bottom right loading>
    </v-btn>
  </div>
</template>


<script>
    export default {
        props: ["cima"],
        data: function() {
            return {
                mount: false,
                completed:false,
                loading: false,
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

            add: function(){
                event.preventDefault();
                var self = this;
                this.loading = true;
                axios.post(this.baseUrl + '/ajax/update-logro',{
                    action: 'add',
                    logro: this.userLogro,
                    cima: this.cima,
                }).then(function(response){
                    if (response.data) {
                        self.userLogro = response.data;
                        self.completed = true;
                        self.loading = false;
                    }
                });
            },

            remove: function(event){
                event.preventDefault();
                var self = this;
                this.loading = true;
                axios.post(this.baseUrl + '/ajax/update-logro',{
                    action: 'remove',
                    logro: JSON.stringify(this.userLogro),
                }).then(function(response){
                    if (!response.data) {
                        self.userLogro = null;
                        self.completed = false;
                        self.loading = false;
                    }
                });
            },


        }
    }

</script>
