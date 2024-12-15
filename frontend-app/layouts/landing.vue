<script setup lang="ts">
</script>

<template>
  <div>
    <div class="">
      <LandingTopHeader />
      <!--      Nav-->
      <div class="bg-sky-100">
        <GuestNav />
      </div>
<!--      Content-->
      <div class="">
        <slot />
      </div>
<!--      Footer-->
      <div class="">
          <GuestTheFooter />
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
