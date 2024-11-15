<script setup lang="ts">
definePageMeta({
  title: 'Admin-Documents',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Documents')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    Admin - Documents
  </div>
</template>

<style scoped></style>
