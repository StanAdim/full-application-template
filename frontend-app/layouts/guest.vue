<script setup lang="ts">
</script>

<template>
  <div>
    <div class="">
      <div class="appBg flex justify-center">
        <div class="text-white py-2">
          <span>The United Republic of Tanzania | Information and Communication Technologies Commission</span>
        </div>
      </div>
      <!--      Nav-->
      <div class="bg-fade">
        <GuestNav />
      </div>
      <!--      Content-->
      <div class="container mx-auto my-2">
        <slot />
      </div>
      <!--      Footer-->
      <div class=""></div>
    </div>
  </div>
</template>

<style scoped>

</style>
