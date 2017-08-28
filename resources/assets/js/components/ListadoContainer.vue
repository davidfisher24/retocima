<template > 
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar-nav">
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                        <ul class="nav navbar-nav">
                            List
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            Main Thing
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
            console.log("Mounted");
        },

        methods: {

            /**
             * Triggers a change of table on changing api route
             * @trigger changeApiRoute() click envent
             * @param event
             * @result changes the visible table via ajax
            */


        }
    }
</script>
