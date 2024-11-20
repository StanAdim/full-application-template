<script setup lang="ts">
definePageMeta({
  title: 'Admin - Grassroot Programs',
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
    Admin - Grassroot Programs
  </div>
</template>

<style scoped></style>
