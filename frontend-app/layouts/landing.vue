<script setup lang="ts">
</script>

<template>
  <div>
    <div class="">
      <LandingTopHeader />
      <!--      Nav-->
      <div class="bg-fade">
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
