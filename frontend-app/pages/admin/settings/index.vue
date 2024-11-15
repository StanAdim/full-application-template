<script setup lang="ts">
definePageMeta({
  title: 'Admin-Settings',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Settings')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    Admin - Settings
  </div>
</template>

<style scoped></style>
v