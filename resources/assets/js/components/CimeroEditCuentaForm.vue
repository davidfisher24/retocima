<template> 
    <div class="row">
        <div class="col-md-12">

            <!-- SECTION: show (presentation of information) -->

            <div v-if="section === 'show'">
                <div>
                    <div><p><strong>Nombre:</strong>   {{cimero.nombre}} </p></div>
                    <div><p><strong>Apellido 1:</strong>   {{cimero.apellido1}} </p></div>
                    <div><p><strong>Apellido 2:</strong>   {{cimero.apellido2}} </p></div>
                    <div><p><strong>Usuario:</strong>   {{cimero.username}} </p></div>
                    <div><p><strong>Correo Electronico:</strong>   {{cimero.email}}  </p></div>
                    <span><a v-on:click="section = 'data'">Editar Datos</a></span>
                </div>
                <br>
                <div>
                    <div id="province" v-show="isSpain"><p><strong>Provincia:</strong>   {{cimero.provincia.nombre}}  </p></div>
                    <div id="country"><p><strong>Pais:</strong>   {{cimero.pais.nombre}} </p></div>
                    <span><a v-on:click="section = 'location'">Editar Ubicacion</a></span>
                </div>
                <br>
                <div>
                    <div id="birthdate"><p><strong>Fecha Nacimiento:</strong>   {{cimero.fechanacimiento}} </p></div>
                    <span><a v-on:click="section = 'birthdate'">Editar Fecha Nacimiento</a></span>
                </div>
            </div>

             <!-- SECTION: data (edit data fields) -->

            <div v-if="section === 'data'">
                <form class="form-inline">
                    <label for="nombre">Nombre</label>
                    <div class="form-group">
                        <input type="text" name="nombre" v-model="updateCimero.nombre" class="form-control"><span class="error"></span>
                    </div><br><br>
                    <label for="apellido1">Apellido 1</label>
                    <div class="form-group">
                        <input type="text" name="apellido1" v-model="updateCimero.apellido1" class="form-control"><span class="error"></span>
                    </div><br><br>
                    <label for="apellido2">Apellido2</label>
                    <div class="form-group">
                        <input type="text" name="apellido2" v-model="updateCimero.apellido2" class="form-control"><span class="error"></span>
                    </div><br><br>
                    <label for="username">Usuario</label>
                    <div class="form-group">
                        <input type="text" name="username" v-model="updateCimero.username" class="form-control"><span class="error"></span>
                    </div><br><br>
                    <label for="email">Correo Electronico</label>
                    <div class="form-group">
                        <input type="text" name="email" v-model="updateCimero.email" class="form-control"><span class="error"></span>
                    </div>
                <br>
                <button class="btn btn-primary" @click="edit">Editar</button>
                <div>
                    <span><a @click="cancel">ANULAR</a></span>
                    <span><a @click="reset">RESET</a></span>
                </div>
                </form>
            </div>

            <!-- SECTION: location (edit location selects) -->
            <div v-if="section === 'location'">
                <form class="form-inline">

                    <label for="pais">Pais</label>
                    <div class="form-group">
                        <select name="pais" v-model="updateCimero.pais.id" @change="checkSpain()">
                            <option v-for="country in countries" v-bind:value="country.id">{{country.nombre}}</option>
                        </select>
                        <span class="error"></span>
                    </div><br><br>

                    <label for="provincia" v-show="isSpain">Provincia</label>
                    <div class="form-group" v-show="isSpain">
                        <select name="provincia" v-model="updateCimero.provincia.id">
                            <option v-for="province in provinces" v-bind:value="province.id">{{province.nombre}}</option>
                        </select>
                        <span class="error"></span>
                    </div>
    
                <br>
                <button class="btn btn-primary" @click="edit">Editar</button>
                <div>
                    <span><a @click="cancel">ANULAR</a></span>
                    <span><a @click="reset">RESET</a></span>
                </div>
                </form>
            </div>


            <!-- SECTION: birthdate (edits nirthdate) -->
            <div v-if="section === 'birthdate'">
                <form class="form-inline">

                    <label for="fechanacimiento">Fecha de Nacimiento</label>
                    <div class="form-group">
                        <input type="date" name="fechanacimiento" v-model="updateCimero.fechanacimiento" class="form-control"><span class="error"></span>
                    </div><br><br>
    
                <br>
                <button class="btn btn-primary" @click="edit">Editar</button>
                <div>
                    <span><a @click="cancel">ANULAR</a></span>
                    <span><a @click="reset">RESET</a></span>
                </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['cimeromodel','provincias','paises'],
        data: function() {
            return {
                cimero : null,
                spainId: null, // The Spain id for chcking if Spain is selected
                isSpain: false,  // Checking Spain selection for the provinces dropdown
                section: "show", // Section to display
                updateCimero: null // Updates applied to the cimero model
            };
        },
        computed: {
            basecimero : function(){
                return JSON.parse(this.cimeromodel);
            },
            provinces : function(){
                return JSON.parse(this.provincias);
            },
            countries : function(){
                return JSON.parse(this.paises);
            },
        },
        beforeMount: function() {
            var self = this;
            this.cimero = Object.assign({}, this.basecimero);
            this.updateCimero = Object.assign({}, this.basecimero);
            this.findSpain();
            this.checkSpain();
        },

        methods: {


            /**
             * Find the id of spain in the countries list for tracking
             * @result stores a reference for the Spain ID
            */

            findSpain:function(){
                var self = this;
                this.countries.forEach(function(country){
                    if(country.nombre === "España") self.spainId = country.id; 
                })
            },

            /**
             * Checks if the current users province is set as Spain
             * @result stores true or false for Spain
            */

            checkSpain:function(){
                this.isSpain = this.cimero.pais.id === this.spainId ? true : false;
            },

    

            /**
             * Edits the form and updates after callback
             * @param {event}
             * @result updates form and updates all data
            */

            edit:function(event){
                event.preventDefault();
                var self = this;
                var updateData = {
                    apellido1: this.updateCimero.apellido1,
                    apellido2: this.updateCimero.apellido2,
                    nombre: this.updateCimero.nombre,
                    username: this.updateCimero.username,
                    email: this.updateCimero.email,
                    provincia: this.updateCimero.provincia.id,
                    pais: this.updateCimero.pais.id,
                    fechanacimiento: this.updateCimero.fechanacimiento,
                }
                axios.post('editarcuenta',updateData).then(function(response){
                    if (response.data.errors) {
                        self.showErrors(response.data.errors);
                    } else {
                       self.cimero = Object.assign({}, response.data);
                       self.updateCimero = Object.assign({}, response.data);
                       self.section = 'show'; 
                    }
                    
                });
            },

            /**
             * Cancels changes and returns the show page
            */

            cancel:function(){
                this.updateCimero = Object.assign({}, this.cimero);
                this.section = 'show';
            },

            /**
             * Resets all changes
            */

            reset:function(){
                this.updateCimero = Object.assign({}, this.cimero);
            },

            /**
             * Shows any errors and triggers fade out timer
             * @param {Object} errors
            */

            showErrors:function(errors){
                for (var key in errors) {
                    var inputEl = document.querySelectorAll('[name="'+key+'"]')[0];

                    var normalColor = inputEl.style.borderColor
                    inputEl.style.borderColor = "red";
                    inputEl.nextSibling.innerHTML = errors[key];

                    setTimeout(function(){ 
                        inputEl.style.borderColor = normalColor;
                        inputEl.nextSibling.innerHTML = '';
                    }, 3000);
                }
            },

  

            
        }
    }
</script>
