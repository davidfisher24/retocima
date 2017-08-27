<template> 
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar-nav">
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    De Cimeros
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute">Por número de cimas ascendidos</a></li>
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="api/statistics/cimerosbyprovincesstarted/">Por provincias comenzadas</a></li>
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute">Por provincias completadas</a></li>
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute">Por CC.AA. completadas</a></li>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    De Cimas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#" @click="changeApiRoute" data-apiroute="api/statistics/cimasbylogro">CIMAs más ascendidos</a></li>
                                    <li><a class="dropdown-item" @click="changeApiRoute" href="#" data-apiroute="api/statistics/provincesbylogro/">Provincias más ascendidas</a></li>
                                    <li><a class="dropdown-item" @click="changeApiRoute" href="#">Provincias más completadas</a></li>
                                    <li><a class="dropdown-item" @click="changeApiRoute" href="#" data-apiroute="api/statistics/comunidadsbylogro/">CC.AA. más ascendidas</a></li>
                                    <li><a class="dropdown-item" @click="changeApiRoute" href="#">CC.AA. más completadas</a></li>
                                </div>
                            </li>
                            <li><a href="#" @click="changeApiRoute">Por Comunidad Autonoma</a></li>
                            <li><a href="#" @click="changeApiRoute">Por Provincia</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <datatable v-for="route in routesCalled" v-if="tableLoaded && apiroute === route" :key="route"></datatable>
        </div>
    </div>
</template>



<script>
    export default {
        data: function() {
            return {
                tableLoaded: false,
                apiroute: false,
                routesCalled: [],
            };
        },
        computed: {


        },

        methods: {

            /**
             * Gets the requested data for the datatable
             * @trigger onMounted()
             * @result returns a dataobject and count
            */

            changeApiRoute: function(event){
                if (this.routesCalled.indexOf(event.target.dataset.apiroute) === -1)
                    this.routesCalled.push(event.target.dataset.apiroute);
                this.apiroute = event.target.dataset.apiroute;
                this.tableLoaded = true;
            }
        }
    }
</script>
