<template> 
    <div class="row">
        <loadingcontainer v-if="loading"></loadingcontainer>
        <div class="col-md-12" v-if="!loading">

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
                <div v-if="provinces && countries && isSpain">
                    <div id="province" v-if="isSpain"><p><strong>Provincia:</strong>   {{cimero.provincia.nombre}}  </p></div>
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

                    <label for="provincia" v-if="isSpain">Provincia</label>
                    <div class="form-group" v-if="isSpain">
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
        data: function() {
            return {
                cimero : null,
                spainId: null, // The Spain id for chcking if Spain is selected
                isSpain: false,  // Checking Spain selection for the provinces dropdown
                section: "show", // Section to display
                updateCimero: null, // Updates applied to the cimero model
                provinces: null,
                countries: null,
                loading: true,
                loaded: 0,
            };
        },

        mounted: function (){
            this.getCimero();
            this.getProvinces();
            this.getCountries();
        },

        watch: {
            loaded: function(update,old){
                if (update === 3) {
                   this.findSpain();
                   this.checkSpain();
                   this.loading = false;
                }
            },
        },

        methods: {

            getCimero: function(){
                var self = this;
                axios.get(this.baseUrl + '/ajax/cimero').then(function(response){
                    console.log(response.data);
                   self.cimero = response.data;
                   self.updateCimero = self.cimero;
                   self.loaded++;
                });
            },

            getProvinces: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/provincias').then(function(response){
                    console.log(response.data);
                   self.provinces = response.data;
                   self.loaded++;
                });
            },

            getCountries: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/paises').then(function(response){
                    console.log(response.data);
                   self.countries = response.data;
                   self.loaded++;
                });
            },

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
             * @result stores true or false for Spain. Sets a default province for isSpain and null province
            */

            checkSpain:function(){
                var self = this;
                this.isSpain = this.cimero.pais.id === this.spainId ? true : false;
                if (this.updateCimero.provincia === null && this.isSpain) {
                    this.updateCimero.provincia = self.provinces[Object.keys(self.provinces)[0]];
                }
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
                    provincia: this.updateCimero.provincia ? this.updateCimero.provincia.id : null,
                    pais: this.updateCimero.pais.id,
                    fechanacimiento: this.updateCimero.fechanacimiento,
                }
                axios.post(this.baseUrl + '/ajax/editarcuenta',updateData).then(function(response){
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
