<script setup lang="ts">
definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
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
    Admin - Dashboard
  </div>
</template>

<style scoped></style>
