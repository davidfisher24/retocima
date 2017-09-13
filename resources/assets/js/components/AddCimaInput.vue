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
                communidads: this.$parent.communidads,
                userLogros: this.$parent.userLogros,
                provincias: [],
                cimas: [],
                selectedCommunidad: null,
                selectedProvince: null,
                selectedCima: null,
            };
        },
        computed: {

            /**
             * Checked that an input has been completed
             * @trigger The parent form Submit button
             * @return boolean
            */

            completed: function () {
                if(this.selectedCommunidad && this.selectedProvince && this.selectedCima) return true;
                return false;
            }
        },

        methods: {

            /**
             * Fills in a province list or empties other fields when changing a communidad input
             * @trigger Change Communidad Input
             * @params event
             * @result Triggers ajax call to get provinces or empties the other inputs
            */

            handleChangedCommunidad: function(event){
                if (!event.target.value) {
                    this.cimas = [];
                    this.provincias = [];
                    this.selectedCommunidad = null;
                    return;
                }
                this.selectedCommunidad = event.target.value;
                this.cimas = [];
                var route = './api/provincias/' + event.target.value;
                var self = this;
                axios.get(route).then(function(response){
                    self.provincias = response.data;
                    if (response.data.length === 1) {
                        // Needs to auto fill the provincia before getting the cimas
                        // self.handleChangedProvincia(response.data[0].id);
                    }
                });
            },

            /**
             * Fills in a cima list or empties cima list when changing a province input
             * @trigger Change Province Input
             * @params event
             * @result Triggers ajax call to get cimas or empties the cima input
            */

            handleChangedProvincia: function(event){
                var route;
                if (Number.isInteger(event)) {
                    this.selectedProvince = event;
                    route = './api/cimas' + event;
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

            /**
             * Adds or removes a cima from list of completed cimas to prevent repetition
             * @trigger Change Cima Input
             * @params event
             * @result Updates cima inputs
            */

            handleChangedCima: function(event){
                if (!event.target.value) {
                    this.userLogros.splice(this.userLogros.indexOf(this.selectedCima), 1);
                    this.selectedCima = null;
                    return;
                }
                this.userLogros.push(Number(event.target.value));
                this.selectedCima = event.target.value;
            },

            /**
             * Checks if a logro has already been completed
             * @trigger Prepating a list of cimas
             * @params id
             * @result v-show on the cima input list
            */

            logroAlreadyCompleted: function(id){
                if (this.userLogros.indexOf(id) !== -1) return false;
                return true;
            },

            /**
             * Checks if the province list should be visible
             * @trigger this.data.provincias
             * @return boolean
             * @result disables the input field if false
            */

            provinciasVisible : function(){
                if (this.provincias.length === 0) return true;
                return false;
            },

            /**
             * Checks if the cima list should be visible
             * @trigger this.data.cimas
             * @return boolean
             * @result disables the input field if false
            */

            cimasVisible: function(){
                if (this.cimas.length === 0) return true;
                return false;
            }
        }
    }

</script>
