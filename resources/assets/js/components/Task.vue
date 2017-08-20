<template> 
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
                <strong>{{cima.codigo}}</strong> {{cima.nombre}}
            </option>
        </select>

    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                communidads: [],
                provincias: [],
                cimas: [],
                userLogros: [],
            };
        },
        methods: {
            setCommunidadsFromParent: function(data) {
                this.communidads = data;
            },
            setUserLogrosFromParent: function(data) {
                this.userLogros = data;
            },
            fetchAndShowProvinces: function(event){
                this.cimas = [];
                var route = 'api/provincias/' + event.target.value;
                var self = this;
                axios.get(route).then(function(response){
                    self.provincias = response.data;
                    if (response.data.length === 1) {
                        self.fetchAndShowCimas(response.data[0].id);
                        self.$parent.completedInputs ++;
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
                this.$parent.completedInputs ++;
            }
        }
    }
</script>
