<template> 
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
        <CimaQuickAdd :cima="cima"></CimaQuickAdd>
        <v-card flat>
          <v-card-text>

                <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4 col-xl-4">
                        <div class="row">
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>Altitud:</strong></p></div>
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{cima.vertientes[i].altitud}}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>Desnivel:</strong></p></div>
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{cima.vertientes[i].desnivel}}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>Longitud:</strong></p></div>
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{cima.vertientes[i].longitud}}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>% medio:</strong></p></div>
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{cima.vertientes[i].porcentage_medio}}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>% máx.:</strong></p></div>
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{cima.vertientes[i].porcentage_maximo}}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p><strong>APM:</strong></p></div>
                            <div class="col-md-6 col-xs-6 col-lg-6 col-xl-6 col-sm-6"><p>{{cima.vertientes[i].apm}}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12 col-sm-12"><p><strong>ENLACES</strong></p></div>

                        </div>
                        <div class="row" v-if="cima.vertientes[i].enlaces.length === 0">
                            <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12 col-sm-12"><p>No Disponible!</p></div>
                        </div>
                        <div class="row" v-for="(enlace,index) in cima.vertientes[i].enlaces" >
                            <a :href="enlace.url" target="_blank"><div class="col-md-12 col-xs-12 col-lg-12 col-xl-12 col-sm-12"><p>Enlace {{index + 1}}</p></div></a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12 col-lg-8 col-xl-8">
                        <PathMap :id="cima.vertientes[i].id"></PathMap>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-left">
                <p><strong>Inicio: </strong>{{cima.vertientes[i].inicio}}</p>
                <p><strong>Dudas:  </strong>{{cima.vertientes[i].dudas}}</p>
                <p><strong>Final:  </strong>{{cima.vertientes[i].final}}</p>
                <p><strong>Observaciones: </strong>{{cima.vertientes[i].observaciones}}</p>
            </div>
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs>
</template>

<script>
    import PathMap from '../components/Maps/PathMap';
    import CimaQuickAdd from './CimaQuickAdd';

    export default {
        props: ["cima"],
        components: {
            'PathMap' : PathMap,
            'CimaQuickAdd' : CimaQuickAdd,
        },
        data: function() {
            return {
                active:0,
            };
        },
    }

</script>
