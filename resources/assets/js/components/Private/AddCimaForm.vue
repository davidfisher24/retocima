<template> 
 
    <v-form class="px-5"  v-model="valid" lazy-validation>
        <v-flex md12 xs12>
            <v-alert type="error" dismissible v-model="failure" transition="scale-transition">
              Hay cimas sin completar
            </v-alert>
                <v-layout  v-for="input in inputs" :key="input">
                  <AddCimaInput ref="addcimainput" :communidads="communidads" :userLogros="userLogros" @chosenACima="chosenACima"></AddCimaInput>
                    <v-btn flat color="black" @click="removeInput(input)">X</v-btn>
                </v-layout>

              <v-btn @click="submitLogros">Submitir Cimas</v-btn>
              <v-btn @click="otherCima">Anadir otra cima</v-btn>
        </v-flex>


    </v-form>

</template>

<script>

    import AddCimaInput from './AddCimaInput';

    export default {
        components: {
            'AddCimaInput' : AddCimaInput,
        },

        data: function() {
            return {
                requestedInputs: 0,
                userLogros: [],
                communidads: [],
                valid: true,
                failure: false,
                inputs: [Math.random()],
            };
        },
        mounted: function() {
            this.fetchUserLogros();
            this.fetchCommunidads();
        },

        watch: {
          steps (val) {
            if (this.e1 > val) {
              this.e1 = val
            }
          }
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
                axios.get(self.baseUrl + '/ajax/userlogros').then(function(response){
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
                var self = this;
                this.$refs.addcimainput.forEach(function(component){
                    if(component.completed) {
                        logros.push(component.selectedCima);
                    }
                });
                console.log(logros);
                console.log(this.inputs);
                console.log(this.inputs.length);
                if (logros.length === this.inputs.length) {
                    axios.post(self.baseUrl + '/ajax/submitlogros', {
                        logros: logros,
                    })
                    .then(function (response) {
                        self.$emit('addedCimas', response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                        self.failure = true;
                    }); 
                } else {
                    self.failure = true;
                }         
            },

            otherCima: function(){
                this.inputs.push(Math.random());
            },

            removeInput: function(key){
                var index = this.inputs.indexOf(key);
                this.inputs.splice(index, 1);
            },

            chosenACima: function(id){
                this.userLogros.push(id);
            },
        }
    }
</script>
