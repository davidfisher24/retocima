<template> 
    <div>
    <v-toolbar color="primary">
        <v-toolbar-title class="white--text">{{cima.codigo}} {{cima.nombre}}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn flat color="white" v-if="back" @click="$emit('back',null)">Atras</v-btn>
          <v-btn flat color="white" v-if="carousel" @click="$emit('carousel-previous',null)">Anterior</v-btn>
          <v-btn flat color="white" v-if="carousel" @click="$emit('carousel-next',null)">Siguiente</v-btn>
        </v-toolbar-items>
      </v-toolbar color="secondary">
      <v-system-bar status color="primary" dark>
        <span>{{cima.provincia}} / {{cima.communidad}}</span>
      </v-system-bar>
      <v-system-bar status color="primary" dark>
        <span>GPS:  Latitude: {{cima.latitude}}  Longitude: {{cima.longitude}}</span>
      </v-system-bar>
    <v-tabs
      v-model="active"
      color="cyan"
      dark
      slider-color="yellow"
    >
      <v-tab
        v-for="n,i in cima.vertientes"
        :key="i"
        ripple
      >
        {{ cima.vertientes[i].vertiente }} 
      </v-tab>
      <v-tab-item
        v-for="n,i in cima.vertientes"
        :key="i"
      >
        <CimaQuickAdd :cima="cima" v-if="quickAdd"></CimaQuickAdd>
            <v-layout wrap>
                <v-flex md4 xs12>
                    <v-card raised class="pa-2">
                        <v-layout>
                            <v-flex md6><p><strong>Altitud:</strong></p></v-flex>
                            <v-flex md6><p>{{cima.vertientes[i].altitud}}</p></v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex md6><p><strong>Desnivel:</strong></p></v-flex>
                            <v-flex md6><p>{{cima.vertientes[i].desnivel}}</p></v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex md6><p><strong>Longitud:</strong></p></v-flex>
                            <v-flex md6><p>{{cima.vertientes[i].longitud}}</p></v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex md6><p><strong>% medio:</strong></p></v-flex>
                            <v-flex md6><p>{{cima.vertientes[i].porcentage_medio}}</p></v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex md6><p><strong>% máx.:</strong></p></v-flex>
                            <v-flex md6><p>{{cima.vertientes[i].porcentage_maximo}}</p></v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex md6><p><strong>APM:</strong></p></v-flex>
                            <v-flex md6><p>{{cima.vertientes[i].apm}}</p></v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex md12><p><strong>ENLACES</strong></p></v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex md12 v-if="cima.vertientes[i].enlaces.length === 0"><p>No Disponible!</p></v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex md12 v-for="(enlace,index) in cima.vertientes[i].enlaces" :key="index"><p>Enlace {{index + 1}}</p></v-flex>
                        </v-layout>
                    </v-card>
                </v-flex>
                <v-flex md8 xs12>
                    <PathMap :id="cima.vertientes[i].id" class="pa-2"></PathMap>
                </v-flex>
            </v-layout>
            <v-card raised class="pa-2">
                <v-layout>
                    <v-flex md12><p><strong>Inicio: </strong>{{cima.vertientes[i].inicio}}</p></v-flex>
                </v-layout>
                <v-layout>
                    <v-flex md12><p><strong>Dudas:  </strong>{{cima.vertientes[i].dudas}}</p></v-flex>
                </v-layout>
                 <v-layout>
                    <v-flex md12><p><strong>Final:  </strong>{{cima.vertientes[i].final}}</p></v-flex>
                </v-layout>
                <v-layout>
                    <v-flex md12><p><strong>Observaciones: </strong>{{cima.vertientes[i].observaciones}}</p></v-flex>
                </v-layout>
            </v-card>
      </v-tab-item>
    </v-tabs>
    </div>
</template>

<script>
    import PathMap from '../Maps/PathMap';
    import CimaQuickAdd from './CimaQuickAdd';

    export default {
        props: ["cima","carousel","back","quickAdd"],
        components: {
            'PathMap' : PathMap,
            'CimaQuickAdd' : CimaQuickAdd,
        },
        data: function() {
            return {
                active:0,
            };
        },
        computed: {
            properties: function(){
                return [
                    {title: 'Altitud', value: this.cima.vertientes[this.active] ? this.cima.vertientes[this.active].altitud + "m" : " - "},
                    {title: 'Desnivel', value: this.cima.vertientes[this.active] ? this.cima.vertientes[this.active].desnivel + "m" : " - "},
                    {title: 'Logitud', value: this.cima.vertientes[this.active] ? this.cima.vertientes[this.active].longitud + "m" : " - "},
                    {title: '% Medio', value: this.cima.vertientes[this.active] ? this.cima.vertientes[this.active].porcentage_medio + "%" : " - "},
                    {title: '% Maximo', value: this.cima.vertientes[this.active] ? this.cima.vertientes[this.active].porcentage_maximo + "%" : " - "},
                    {title: 'APM', value: this.cima.vertientes[this.active] ? this.cima.vertientes[this.active].apm : " - "},
                ]
            },
        },

    }

</script>
