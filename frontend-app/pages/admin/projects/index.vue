<script setup lang="ts">
definePageMeta({
  title: 'Admin-Projects',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Projects')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    Admin - Projects
  </div>
</template>

<style scoped></style>
