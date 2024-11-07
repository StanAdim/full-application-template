<script setup lang="ts">

</script>

<template>
  <div class="container mx-auto ">
    <div class="flex flex-row justify-between">
      <div class="md:w-1/2 mx-4">
        <!--              title-->
        <div class="">
          <div class="md:text-[60px] text-[30px]   md:mt-12 mt-2">
            <div class="leading-none py-0.5 font-extrabold"><span class="appColor">ICT</span> innovation</div>
            <div class="leading-none py-0.5 font-extrabold">Solutions and</div>
            <div class="leading-none py-0.5 font-extrabold">Investment</div>
            <div class="leading-none py-0.5 font-extrabold appColor">Ecosystem Portal</div>
          </div>
        </div>
        <!--              Description-->
        <div class="mt-4">
          <div class="md:w-2/3">
            <p class="desc">This portal registers <span>ICT Startups</span> , <span>Developers</span> , <span>Incubators</span> , <span>Hubs</span>
              and <span>Grassroot Programs</span> along with their on going
              Projects and products to create a network of actors in the
              ICT business ecosystem.</p>
          </div>
        </div>
        <!--              btn-->
        <div class="mt-4">
          <nuxt-link to="/register" >
            <button type="button" class="sm:w-auto  rounded-full bg-green-600 text-white font-semibold py-4 px-10  hover:bg-green-700">
              Register Now →
            </button>
          </nuxt-link>
        </div>
      </div>
      <div class="md:w-1/2 hidden md:block">
        <div class="bg-cover h-[60vh] bg-center bg-no-repeat bg-[url('/images/img-opt.png')]" ></div>
<!--        <div class="flex justify-end max-h-fit">-->
<!--          <img class="h-[60vh]" src="/images/img(8).png" alt="">-->
<!--        </div>-->
      </div>
    </div>
  </div>

</template>

<style scoped>
.desc span{
  @apply font-bold text-black
}
</style>