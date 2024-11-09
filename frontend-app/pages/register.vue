<script setup lang="ts">
definePageMeta({
  title: 'Register',
  layout: 'guest',
})
const globalData = useGlobalDataStore()
const config = useRuntimeConfig();
const options = [
  {label: 'ICT Startup', path: '/registrations/ict-startups'},
  {label: 'Incubation Hub', path: '/registrations/innovation-hubs'},
  {label: 'Digital Accelerator', path: '/registrations/digital-accelerators'},
  {label: 'Grassroot Program', path: '/registrations/grassroot-programs'},
  // "Graphic Designer",
  // "Large Company",
  // "Investor"
]
</script>

<template>
  <div class="flex flex-col items-center justify-center mt-2 md:mt-5 md:pt-4">
    <!-- Heading Section -->
    <div class="text-center mb-10 ">
      <p class="md:text-md text-sm font-semibold appColor uppercase">WELCOME TO {{ config.public.appName }}</p>
      <h1 class="md:text-4xl text-2xl font-bold appColor mt-2">Whom would you <br /> like to join as?</h1>
    </div>

    <!-- Grid Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <div
          v-for="option in options"
          :key="option"
          class="flex items-center flex-col justify-center hover:cursor-pointer m-1 h-48 w-64 rounded-lg border border-gray-300 shadow-md hover:bg-blue-50 transition">
        <nuxt-link :to="option.path" >
          <div class="appColor font-semibold text-xl">{{ option.label }}</div>
          <div class="appColor pt-4 hover:underline text-center">Join</div>
        </nuxt-link>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>