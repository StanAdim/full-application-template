<script setup lang="ts">
definePageMeta({
  title: 'Admin-Profiles',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Profiles')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    Admin - Profiles
  </div>
</template>

<style scoped></style>
