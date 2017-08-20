<template> 
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="form">

                <div class="input-group" v-for="n in inputs">

                    <select @change="showProvinces($event)">
                        <option v-for="communidad in communidads" :value="communidad.id">
                            {{communidad.nombre}}
                        </option>
                    </select>

                    <select @change="showCimas($event)">
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
                inputs: 1,
                communidads: [{id:1,nombre:"Comm 1"},{id:2,nombre:"Comm 2"}],
                provincias: [{id:1,nombre:"Prov 1"},{id:2,nombre:"Prov 2"}],
                cimas: [{id:1,nombre:"Cima 1"},{id:2,nombre:"Cima 2"}],
            };
        },
        methods: {
            showProvinces: function(event){
                console.log(event.target.value);
            },
            showCimas: function(event){
                console.log(event.target.value);
            },
            tagOptionCompleted: function(){
                this.inputs ++;
            }
        }
    }
</script>
