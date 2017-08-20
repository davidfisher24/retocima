<template> 
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="form">
                <task ref="task1"></task>
                <task v-show="completedInputs > 0" ref="task2"></task>
                <task v-show="completedInputs > 1" ref="task3"></task>
                <task v-show="completedInputs > 2" ref="task4"></task>
                <task v-show="completedInputs > 3" ref="task5"></task>
                <task v-show="completedInputs > 4" ref="task6"></task>
                <task v-show="completedInputs > 5" ref="task7"></task>
                <task v-show="completedInputs > 6" ref="task8"></task>
                <task v-show="completedInputs > 7" ref="task9"></task>
                <task v-show="completedInputs > 8" ref="task10"></task>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                completedInputs: 0,
                userLogros: [],
                communidads: [],
            };
        },
        mounted: function() {
            this.fetchCommunidads();
        },
        methods: {
            fetchUserLogros: function(){
                var self = this;
                axios.get('api/userlogros').then(function(response){
                    self.userLogros = response.data;
                    for (var key in self.$refs) self.$refs[key].setuserLogrosFromParent(response.data);
                });
            },
            fetchCommunidads: function(){
                var self = this;
                axios.get('api/communidads').then(function(response){
                    self.communidads = response.data;
                    for (var key in self.$refs) self.$refs[key].setCommunidadsFromParent(response.data);
                });
            },
        }
    }
</script>
