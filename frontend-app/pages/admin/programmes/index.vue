<script setup lang="ts">
definePageMeta({
  title: 'Admin-Programmes',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Programmes')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    Admin - Programmes
  </div>
</template>

<style scoped></style>
