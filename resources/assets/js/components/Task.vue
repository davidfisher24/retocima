<template> 
    <div class="input-group">

        <select @change="handleChangedCommunidad($event)">
            <option value="">-- commundiad --</option>
            <option v-for="communidad in communidads" :value="communidad.id">
                {{communidad.nombre}}
            </option>
        </select>

        <select @change="handleChangedProvincia($event)">
            <option value="">-- provincia --</option>
            <option v-if="provinciasVisible()" disabled>- select a communidad -</option>
            <option v-for="provincia in provincias" :value="provincia.id">
                {{provincia.nombre}}
            </option>
        </select>

        <select @change="handleChangedCima($event)">
            <option value="">-- cima --</option>
            <option v-if="cimasVisible()" disabled>- select a province -</option>
            <option v-for="cima in cimas" :value="cima.id" v-show="logroAlreadyCompleted(cima.id)">
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
                selectedCommunidad: null,
                selectedProvince: null,
                selectedCima: null,
            };
        },
        computed: {
            completed: function () {
                if(this.selectedCommunidad && this.selectedProvince && this.selectedCima) return true;
                return false;
            }
        },
        methods: {
            setCommunidadsFromParent: function(data) {
                this.communidads = data;
            },
            setUserLogrosFromParent: function(data) {
                this.userLogros = data;
            },
            handleChangedCommunidad: function(event){
                if (!event.target.value) {
                    this.cimas = [];
                    this.provincias = [];
                    this.selectedCommunidad = null;
                    return;
                }
                this.selectedCommunidad = event.target.value;
                this.cimas = [];
                var route = 'api/provincias/' + event.target.value;
                var self = this;
                axios.get(route).then(function(response){
                    self.provincias = response.data;
                    if (response.data.length === 1) {
                        // Needs to auto fill the provincia before getting the cimas
                        // self.handleChangedProvincia(response.data[0].id);
                    }
                });
            },
            handleChangedProvincia: function(event){
                var route;
                if (Number.isInteger(event)) {
                    this.selectedProvince = event;
                    route = 'api/cimas/' + event;
                } else {
                    if (!event.target.value) {
                        this.selectedProvince = null;
                        this.cimas = [];
                        return;
                    }
                    this.selectedProvince = event.target.value;
                    route = 'api/cimas/' + event.target.value;
                }
                axios.get(route).then(response => {
                  this.cimas = response.data
                });
            },
            handleChangedCima: function(event){
                if (!event.target.value) {
                    this.userLogros.splice(this.userLogros.indexOf(this.selectedCima), 1);
                    this.selectedCima = null;
                    return;
                }
                this.userLogros.push(Number(event.target.value));
                this.selectedCima = event.target.value;
            },

            logroAlreadyCompleted: function(id){
                if (this.userLogros.indexOf(id) !== -1) return false;
                return true;
            },
            provinciasVisible : function(){
                if (this.provincias.length === 0) return true;
                return false;
            },
            cimasVisible: function(){
                if (this.cimas.length === 0) return true;
                return false;
            }
        }
    }

</script>
