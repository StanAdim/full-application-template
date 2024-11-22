<script setup lang="ts">
definePageMeta({
  title: 'Admin - ICT Startups',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const adminStore = useAdminDataStore()


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
