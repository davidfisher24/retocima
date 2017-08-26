<template> 
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <label for="numberInputs">
                        Cuantas cimas quieres anadir?
                        <input type="number" name="numberInputs" min="1" max="20" ref="selectedNumberInputs">
                    </label>
                    <button class="btn btn-default" @click="changeRequestedInputs">Go</button>
                </div>
            </div>
            <form class="form" ref="addLogrosForm" v-on:submit.prevent>
                <div class="form-control" v-for="n in requestedInputs">
                    <addcimainput ref="addcimainput"></addcimainput>
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
                requestedInputs: 0,
                userLogros: [],
                communidads: [],
            };
        },
        mounted: function() {
            this.fetchUserLogros();
            this.fetchCommunidads();
        },
        methods: {

            /**
             * triggers change on the number of inputs
             * @trigger changeReqestedInputs Button
             * @params references selectedNumberInputs Input
             * @result changed the number of requestedInputs
            */

            changeRequestedInputs:function(){
                this.requestedInputs = parseInt(this.$refs.selectedNumberInputs.value);
            },

            /**
             * Axios call to recieved current user logros
             * @trigger onMounted()
             * @result stores the result for reference by the children
            */

            fetchUserLogros: function(){
                var self = this;
                axios.get('api/userlogros').then(function(response){
                    self.userLogros = response.data;
                });
            },

            /**
             * Axios call to recieve list of communidads
             * @trigger onMounted()
             * @result stores the result for reference by the children
            */

            fetchCommunidads: function(){
                var self = this;
                axios.get('api/communidads').then(function(response){
                    self.communidads = response.data;
                });
            },

            /**
             * Triggers the submit of the input form via verification
             * @trigger Click Submit Button
             * @params references the children input values
             * @result submits the form and redirects if the correct number of cimas has been entered
             *         or calls error callbacks
            */

            submitLogros: function(){ 
                var logros = [];
                this.$refs.addcimainput.forEach(function(component){
                    if(component.completed) {
                        logros.push(component.selectedCima);
                    }
                });

                if (logros.length === this.requestedInputs) {
                    axios.post(/*'retocima*/'/submitlogros', {
                        logros: logros,
                    })
                    .then(function (response) {
                        window.location = /*'retocima/public*/'/cimerologrosnew' + "/" + response.data.new;
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                    console.log(this.$refs);
                    this.$refs.addLogrosForm.submit();
                } else {
                    alert("You have logros incomplete");
                }          
            }
        }
    }
</script>
