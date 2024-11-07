<script setup lang="ts">

</script>

<template>
  <div class="flex flex-wrap items-center md:justify-between justify-center bg-gray-100 p-8 rounded-lg">
    <!-- Left Section: Statistics -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-2 md:w-1/3 ">
      <GuestStatItem color="blue-500" number="50+" label="ICT Startups" />
      <GuestStatItem color="black" number="5+" label="Digital Accelerator" />
      <GuestStatItem color="green-500" number="3+" label="Innovation Hubs" />
      <GuestStatItem color="yellow-500" number="2+" label="Grassroot Programs" />
    </div>

    <!-- Right Section: Image -->
    <div class="w-full md:w-2/3 mt-6 md:mt-0">
      <div class="bg-cover h-[50vh] bg-center bg-no-repeat bg-[url('/images/landing/stats-img-opt.png')]" ></div>
    </div>
  </div>
</template>

<style scoped>

</style>