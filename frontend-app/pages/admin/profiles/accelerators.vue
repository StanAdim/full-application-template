<script setup lang="ts">
definePageMeta({
  title: 'Admin - Digital Accelerators',
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
    Admin - Digital Accelerators
  </div>
</template>

<style scoped></style>
