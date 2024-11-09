<script setup lang="ts">
definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  // middleware:'auth'
})
const globalData = useGlobalDataStore()
</script>

<template>
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Dashboard</h2>
    <p class="text-gray-600">
      Welcome to your dashboard. Add your components and content here.
    </p>
  </div>
</template>

<style scoped></style>
