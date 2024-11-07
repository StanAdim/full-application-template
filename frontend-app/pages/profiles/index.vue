<script setup lang="ts">
definePageMeta({
  layout: 'landing',
  // middleware:'guest'
})
useHead({
  title: 'Landing',
})
const globalData = useGlobalDataStore()
</script>
<template>
  <div class="container mx-auto">
    <div class="h-[40vh] py-2 mx-2">
          Registered Profiles
    </div>
  </div>
</template>

<style scoped>

</style>
