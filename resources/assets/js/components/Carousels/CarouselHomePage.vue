<style>
    .slide {
      height: 177px;
    }
    
</style>

<template>
    <main class="banner-image">
        <agile :options="options">
            <div class="slide slide--1" :style="backgroundImage('/img/cima.jpg')"></div>
            <div class="slide slide--2" :style="backgroundImage('/img/cima2.jpg')"></div>
        </agile>
    </main>
</template>

<script>
    import Vue from 'vue'
    import VueAgile from 'vue-agile'
    Vue.use(VueAgile)

    export default {
        data: function() {
            return {
              options: {
                prevArrow: '<svg class="svg-arrow" x="0px" y="0px" viewBox="0 0 24 24"><path d="M16.2,21c0.3,0,0.5-0.1,0.7-0.3c0.4-0.4,0.4-1,0-1.4L9.6,12L17,4.7c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L6.8,12l8.8,8.7C15.7,20.9,16,21,16.2,21z"/></svg>',
                nextArrow: '<svg class="svg-arrow" x="0px" y="0px" viewBox="0 0 24 24"><path d="M7.8,21c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l7.4-7.3L7,4.7c-0.4-0.4-0.4-1,0-1.4s1-0.4,1.4,0l8.8,8.7l-8.8,8.7C8.3,20.9,8,21,7.8,21z"/></svg>',
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
                pauseOnHover: false,
                speed: 750,
                dots: true,
                fade: true,
                timing: "linear",
                mobileFirst: true,
                infinite: true,
              },
            };
        },

        methods: {
            backgroundImage: function(url){
                return "background-image: url("+this.baseUrl + url+")";
            }
        }

    }

</script>
