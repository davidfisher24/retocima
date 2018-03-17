<template>   
<v-layout>
  <v-flex>
  <loadingcontainer v-if="loading"></loadingcontainer>


    <v-form class="px-5" v-if="!loading">
     <v-alert type="success" dismissible v-model="success" transition="scale-transition">
      Tu Cuenta ha sido actualizado con exito.
  </v-alert>

  <v-alert type="error" dismissible v-model="failure" transition="scale-transition">
      {{errMessage}}
  </v-alert>
      <v-text-field
        label="Nombre"
        v-model="updateCimero.nombre"
      ></v-text-field>
      <v-text-field
        label="Apellido 1"
        v-model="updateCimero.apellido1"
      ></v-text-field>
      <v-text-field
        label="Apellido 2"
        v-model="updateCimero.apellido2"
      ></v-text-field>
      <v-text-field
        label="Usuario"
        v-model="updateCimero.username"
      ></v-text-field>
      <v-text-field
        label="Correo Electronico"
        v-model="updateCimero.email"
      ></v-text-field>


      <v-select
        v-if="isSpain"
        :items="provinces"
        item-text="nombre"
        item-value="id"
        v-model="updateCimero.provincia.id"
        label="Provincia"
        class="input-group--focused"
        auto
        autocomplete
      ></v-select>

      <v-select
        :change="checkSpain()"
        :items="countries"
        item-text="nombre"
        item-value="id"
        v-model="updateCimero.pais.id"
        label="Pais"
        class="input-group--focused"
        auto
        autocomplete
      ></v-select>

      <input type="date" name="fechanacimiento" v-model="updateCimero.fechanacimiento" class="form-control"><span class="error"></span>
    

    <v-btn
      @click="submit"
    >
      Cambiar
    </v-btn>
    <v-btn @click="reset">Anular</v-btn>
    </v-form>
  </v-flex>
</v-layout>
</template>

<script>
    export default {
        data: function() {
            return {
                cimero : null,
                spainId: null, // The Spain id for chcking if Spain is selected
                isSpain: false,  // Checking Spain selection for the provinces dropdown
                updateCimero: null, // Updates applied to the cimero model
                provinces: null,
                countries: null,
                loading: true,
                loaded: 0,
                success: false,
                failure: false,
                errMessage: "",
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
                   self.cimero = response.data;
                   self.updateCimero = self.cimero;
                   self.loaded++;
                });
            },

            getProvinces: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/provincias').then(function(response){
                   self.provinces = response.data;
                   self.loaded++;
                });
            },

            getCountries: function(){
                var self = this;
                axios.get(this.baseUrl + '/api/paises').then(function(response){
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
                this.isSpain = this.updateCimero.pais.id === this.spainId ? true : false;
                if (this.updateCimero.provincia === null && this.isSpain) {
                    this.updateCimero.provincia = self.provinces[Object.keys(self.provinces)[0]];
                }
            },

    

            /**
             * Edits the form and updates after callback
             * @param {event}
             * @result updates form and updates all data
            */

            submit:function(event){
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
                        //self.showErrors(response.data.errors);
                        var message = "";
                        for(var key in response.data.errors) message += response.data.errors[key];
                        self.errMessage = message;
                        self.failure = true;
                    } else {
                       self.cimero = Object.assign({}, response.data);
                       self.updateCimero = Object.assign({}, response.data);
                       self.section = 'show'; 
                       self.success = true;
                    }
                    
                });
            },

            /**
             * Cancels changes and returns the show page
            */

            /*cancel:function(){
                this.updateCimero = Object.assign({}, this.cimero);
                this.section = 'show';
            },*/

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
