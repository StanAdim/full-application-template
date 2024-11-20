<script setup lang="ts">
definePageMeta({
  title: 'Admin - ICT Startups',
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
    Admin - ICT Startups
  </div>
</template>

<style scoped></style>
