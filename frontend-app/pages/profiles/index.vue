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
    <div class="h-[100vh] py-2 mx-2">
          Registered Profiles
      <sample />
    </div>
  </div>
</template>

<style scoped>

</style>
