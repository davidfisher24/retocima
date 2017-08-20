<template> 
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="form">

                <div class="input-group">

                    <select @change="fetchAndShowProvinces($event)">
                        <option v-for="communidad in communidads" :value="communidad.id">
                            {{communidad.nombre}}
                        </option>
                    </select>

                    <select @change="fetchAndShowCimas($event)">
                        <option v-for="provincia in provincias" :value="provincia.id">
                            {{provincia.nombre}}
                        </option>
                    </select>

                    <select @change="tagOptionCompleted($event)">
                        <option v-for="cima in cimas" :value="cimas.id">
                            {{cima.nombre}}
                        </option>
                    </select>
    
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                communidads: [],
                provincias: [],
                cimas: [],
            };
        },
        mounted: function() {
            this.fetchCommunidads();
        },
        methods: {
            fetchCommunidads: function(){
                axios.get('api/communidads').then(response => {
                  this.communidads = response.data
                });
            },
            fetchAndShowProvinces: function(event){
                this.cimas = [];
                var route = 'api/provincias/' + event.target.value;
                var self = this;
                axios.get(route).then(function(response){
                    self.provincias = response.data;
                    if (response.data.length === 1) {
                        self.fetchAndShowCimas(response.data[0].id);
                    }
                });
            },
            fetchAndShowCimas: function(event){
                var route;
                if (Number.isInteger(event)) {
                    route = 'api/cimas/' + event;
                } else {
                    route = 'api/cimas/' + event.target.value;
                }
                axios.get(route).then(response => {
                  this.cimas = response.data
                });
            },
            tagOptionCompleted: function(){
                // Need to do something to get the next input
            }
        }
    }
</script>
