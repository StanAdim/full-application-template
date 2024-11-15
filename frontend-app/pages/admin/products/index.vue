<script setup lang="ts">
definePageMeta({
  title: 'Admin-Products',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const init = () => {
  globalData.assignPageTitle('Products')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    Admin - Products
  </div>
</template>

<style scoped></style>
