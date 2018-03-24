<template> 
<v-container fluid class="px-0">
    <loadingcontainer v-if="!cimas"></loadingcontainer>
    <CimaMap v-if="cimas" :cimas="cimas" :center="{lat:40.416775, lng:-3.703790}" :zoom="6"></CimaMap>
</v-container>
</template>



<script>
import CimaMap from '../components/Maps/CimaMap'

    export default {
        components: {
            'CimaMap' : CimaMap,
        },  

        data: function() {
            return {
                cimas: null,
            };
        },

        computed: {

        },

        mounted: function() {
            var self = this;
            axios.get(this.baseUrl + '/api/cimas').then(function(response){
              self.cimas = response.data;
            });
        },

        methods: {
   
        }
    }
</script>
