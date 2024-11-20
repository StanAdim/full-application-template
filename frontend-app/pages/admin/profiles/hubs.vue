<script setup lang="ts">
definePageMeta({
  title: 'Admin - ICT Innovation Hubs',
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
    Admin - ICT Innovation Hubs
  </div>
</template>

<style scoped></style>
