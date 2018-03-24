<style>

@-webkit-keyframes spin-me{
  0% {
    -webkit-transform: rotateZ(0deg);
    transform: rotateZ(0deg);
  }
  100% {
    -webkit-transform: rotateZ(360deg);
    transform: rotateZ(360deg);
  }
}

@keyframes spin-me{
  0% {
    -webkit-transform: rotateZ(0deg);
    transform: rotateZ(0deg);
  }
  100% {
    -webkit-transform: rotateZ(360deg);
    transform: rotateZ(360deg);
  }
}

.spinner {
    opacity: 0.4;
    width:250px;
    -webkit-animation: spin-me 3s linear infinite;
    animation: spin-me 3s linear infinite;
}
</style>

<template> 
    <div class="text-center">
        <img :src="image_src" class="spinner">
        <br>
        <p>CARGANDO ... </p>
    </div>
</template>

<script>
    export default {
        /*data: function() {
            return {
                image_src : this.baseUrl + "/img/icons/wheel.png",
            };
        },*/

        computed: {
          image_src:function(){
            return this.baseUrl + "/img/icons/wheel.png";
          },
        }
    }

</script>
