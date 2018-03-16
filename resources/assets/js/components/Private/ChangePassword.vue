<template> 
  <v-flex xs8>

      <v-alert type="success" :value="success" transition="scale-transition">
        Tu Contrasena ha sido actualizado.
      </v-alert>

      <v-alert type="error" :value="failure" transition="scale-transition">
        {{message}}
      </v-alert>

      <v-text-field
        type="password"
        label="Contrasena Actual"
        v-model="old"
        :disabled="disabled"
      ></v-text-field>

      <v-text-field
        type="password"
        label="Contrasena Nueva"
        v-model="password"
        :disabled="disabled"
      ></v-text-field>

      <v-text-field
        type="password"
        label="Confirmar Contrasena"
        v-model="password_confirmation"
        :disabled="disabled"
      ></v-text-field>

      <v-btn
        @click="submit"
        :disabled="disabled"
      >
        Cambiar
      </v-btn>
      <v-btn @click="clear">Vaciar</v-btn>
    </v-flex>
</template>



<script>


    export default {

      data() {
        return {
          old: "",
          password: "",
          password_confirmation: "",
          disabled: false,
          success: false,
          failure: false,
          message: '',
        }
      },


      methods: {
        clear: function(){
          this.old = '';
          this.password = "";
          this.password_confirmation = "";
        },

        submit: function(){ 
            var self = this;
            this.disabled = true;
            this.failure = false;
            this.success = false;
            if (this.password !== this.password_confirmation) {
              this.failure = true;
              this.message = "La contrasenas no coinciden";
              this.disabled = false;
              return;
            }
            console.log(self.old);
            console.log(self.password);
            axios.post(self.baseUrl + '/change-password', {
                old: self.old,
                password: self.password,
                password_confirmation: self.password_confirmation,
            })
            .then(function (response) {
              self.old = "";
              self.password = "";
              self.password_confirmation = "";
              self.disabled = false;
              self.success = true;
              self.message = response.data.message;
            })
            .catch(function (error) {
              console.log(error.response);
              self.old = "";
              self.password = "";
              self.password_confirmation = "";
              self.disabled = false;
              self.failure = true;

              if (error.response.data.message) self.message = error.response.data.message;
              else self.message = error.response.data.errors[0];
            }); 
      }
    }
  }

</script>
