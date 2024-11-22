<script setup lang="ts">
definePageMeta({
  title: 'Admin - ICT Startups',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const adminStore = useAdminDataStore()

const init = () => {
  globalData.assignPageTitle('Programme List')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>

</template>

<style scoped>

</style>