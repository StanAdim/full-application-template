<script setup lang="ts">
definePageMeta({
  layout: 'landing',
  // middleware:'guest'
})
useHead({
  title: 'Landing',
})
const globalData = useGlobalDataStore()

const route = useRoute()
</script>

<template>
  <div class="">
    {{route.params.profile_type}}
  </div>
</template>

<style scoped>

</style>