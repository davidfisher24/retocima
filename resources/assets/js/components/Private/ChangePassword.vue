<template> 
    <div>
      <div class="panel panel-success" v-if="success">
        <p class="panel-title">{{message}}</p>
      </div>
      <div class="panel panel-danger" v-if="failure">
        <p class="panel-title">{{message}}</p>
      </div>

      <form  role="form" class="form-horizontal" ref="changePasswordForm" v-on:submit.prevent>
    
                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">Contrseña Actual</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="old" v-model="old" :disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">Nueva contraseña</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password" v-model="password" :disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">Confirmar nueva contraseña</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password_confirmation" v-model="password_confirmation" :disabled="disabled"> 
                    </div>
                </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary form-control" @click="submit()">Cambiar</button>
                    </div>
            </div>
    </form>
  </div>
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
