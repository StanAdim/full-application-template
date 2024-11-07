<script setup lang="ts">

</script>

<template>
  <div class="container mx-auto md:py-4 py-2">
    <div class="flex flex-col">
      <div class="my-4">
        <!--            Logos-->
        <div class="flex flex-row md:justify-center justify-between mx-4">
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
          <button class="border-black mx-2 md:hidden">Login</button>
          <ul class="hidden md:flex flex-row flex-wrap gap-4">
            <li class="active nav-link">
              <nuxt-link to="/">Home</nuxt-link>
            </li>
            <li class="nav-link">
              <nuxt-link to="/profiles/">Approved Registrations</nuxt-link>
            </li>
          </ul>
        </div>
        <!--            Accounts-->
        <div class="flex flex-row flex-wrap gap-2 mx-2">

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
  @apply text-sky-500 font-extrabold
}
.nav-link {
  @apply text-lg hover:text-sky-700 font-bold
}
.logo img {
  width: auto;
  height: 100px;
  @apply md:h-[100px] w-auto h-[80px]
}
</style>