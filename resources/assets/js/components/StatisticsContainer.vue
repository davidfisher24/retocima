<template> 
    
    <div class="panel-body">

        <div class="col-md-12">
            <div class="row">
                <datatable></datatable>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        data: function() {
            return {



            };
        },
        computed: {


        },

        mounted: function() {

        },

        methods: {

            /**
             * Gets the requested data for the datatable
             * @trigger onMounted()
             * @result returns a dataobject and count
            */

            fetchData:function(){
                var self = this;
                axios.get('api/ranking').then(function(response){
                    console.log(response.data);
                    self.dataObject = response.data.dataObject;
                    self.filteredData = response.data.dataObject;
                    self.count = response.data.dataObject.length;
                    self.columns = response.data.columns;
                });
            },


        }
    }
</script>
