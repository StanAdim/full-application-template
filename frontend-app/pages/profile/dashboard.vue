<script setup lang="ts">
definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  middleware:'auth',
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Dashboard')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    Dashboard
  </div>
</template>

<style scoped></style>
