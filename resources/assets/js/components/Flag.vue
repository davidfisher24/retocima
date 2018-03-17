<style>
  .flag {
    margin: 2px 4px;
  }
</style>

<template> 
      <img :src="imageSource()" class="flag" height="20" width="24">  
</template>

<script>

    export default {
        props: ["id"],

        methods: {
          imageSource: function(id){
              return this.baseUrl + "/img/communidads/"+this.id+".png";
          },
   
        },
    }

</script>
