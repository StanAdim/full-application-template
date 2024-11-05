<script setup lang="ts">

</script>

<template>
  <div class="container mx-auto md:py-4 py-1">
    <div class="flex flex-col">
      <div class="my-4">
        <!--            Logos-->
        <div class="flex flex-row justify-center">
          <div class="logo">
            <img src="/images/nembo_ya_taifa-opt.png"  alt="logo dark" >
          </div>
          <div class="logo">
            <img src="/images/ictc-logo-white-opt.png"  alt="logo dark" >
          </div>
        </div>
      </div>
      <div class="nav flex flex-row justify-between">
        <div class="">
          <ul class="hidden md:flex flex-row flex-wrap gap-4">
            <li class="active nav-link">
              <nuxt-link to="/">Home</nuxt-link>
            </li>
            <li class="nav-link">
              <nuxt-link to="/profiles/">Registered Profiles</nuxt-link>
            </li>
          </ul>
        </div>
        <!--            Accounts-->
        <div class="flex flex-row flex-wrap gap-2">
          <div class="login">
            <nuxt-link to="/login"><button class="btn border-black">Login</button></nuxt-link>
          </div>
          <div class="register">
            <nuxt-link to="/register"><button class="btn appBg text-white border-sky-500">Register</button></nuxt-link>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<style scoped>

.btn{
  @apply border-2 px-8 py-1 font-bold my-1 rounded-full
}
.router-link-active {
  @apply text-sky-500 font-bold
}
.nav-link {
  @apply text-lg
}
.logo img {
  width: auto;
  height: 100px;
}
</style>