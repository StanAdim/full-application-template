<script setup lang="ts">
definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  middleware:'auth',
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Profile Given')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
      <div class="">Profile Info</div>
</template>

<style scoped>

</style>