<template> 
    <div class="row">
        <div class="col-md-12">
            <form class="form"  v-on:submit.prevent>
                    <!--<div class="form-control" v-for="n in requestedInputs">
                        <addcimainput ref="addcimainput"></addcimainput>
                    </div>-->
                    <p><strong>Nombre:</strong>   {{cimero.nombre}}</p>
                    <p><strong>Apellido 1:</strong>   {{cimero.apellido1}}</p>
                    <p><strong>Apellido 2:</strong>   {{cimero.apellido2}}</p>
                    <p><strong>Usuario:</strong>   {{cimero.username}}</p>
                    <p><strong>Correo Electronico:</strong>   {{cimero.email}}</p>
                    <p><strong>Provincia:</strong>   {{cimero.provincia.nombre}}</p>
                    <p><strong>Pais:</strong>   {{cimero.pais}}</p>
                    <p><strong>Fecha Nacimiento:</strong>   {{cimero.fechanacimiento}}</p>
                    <!--<button class="btn btn-default" @click="submitLogros()">Submit</button>-->
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['cimeromodel'],
        data: function() {
            return {
                provinces: null,
            };
        },
        computed: {
            cimero : function(){
                return JSON.parse(this.cimeromodel);
            },
        },
        mounted: function() {
            this.fetchProvinces();
        },
        methods: {


            /**
             * Axios call to recieve list of provinces
             * @trigger onMounted()
             * @result stores the result for reference by the child menu provincia
            */

            fetchProvinces: function(){
                var self = this;
                axios.get('ajax/provincias').then(function(response){
                    self.provinces = response.data;
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
                    axios.post('./submitlogros', {
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
