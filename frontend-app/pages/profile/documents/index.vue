<script setup lang="ts">
definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  middleware:'auth',
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Account Documents')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">Profile Documents</div>
</template>

<style scoped>

</style>