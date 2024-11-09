<script setup lang="ts">
definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  middleware:'auth',
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('My Account')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>

</template>

<style scoped>

</style>