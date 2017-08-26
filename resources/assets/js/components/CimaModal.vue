<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 600px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3, h5 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-header h5  {
        margin-top: 10px;
        color: #42b983;
    }

    .modal-body h5 {
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }
</style>


<template> 
    <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
             <h3>{{cima.codigo}} - {{cima.nombre}}</h3>
             <h5>{{cima.communidad}} / {{cima.provincia}}</h5>
          </div>

          <div class="modal-body">
              <div v-for="vertiente in vertientes">
                <table class="table">
                    <tr><td><h5><strong>Vertiente</strong></h5></td><td><h5>{{vertiente.vertiente}}</h5></td></tr>
                    <tr><td><strong>Altitud</strong></td><td>{{vertiente.altitud}}</td></tr>
                    <tr><td><strong>Desnivel</strong></td><td>{{vertiente.desnivel}}</td></tr>
                    <tr><td><strong>Longitud</strong></td><td>{{vertiente.longitud}}</td></tr>
                    <tr><td><strong>% Medio</strong></td><td>{{vertiente.porcentage_medio}}</td></tr>
                    <tr><td><strong>% Maximo</strong></td><td>{{vertiente.porcentage_maximo}}</td></tr>
                    <tr><td><strong>APM</strong></td><td>{{vertiente.apm}}</td></tr>
                </table>
              </div>
          </div>

          <div class="modal-footer">
              <button class="modal-default-button btn btn-default" @click="$emit('close')">
                Cerrar
              </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

  



<script>
    export default {
        data: function() {
            return {
                cima: null,
                vertientes: null,
            };
        },


        beforeMount: function() {
            this.cima = this.$parent.modalCima;
            this.vertientes = this.$parent.modalCima.vertientes;
        },

    }
</script>
