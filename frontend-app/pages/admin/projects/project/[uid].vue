<script setup lang="ts">
definePageMeta({
  title: 'Admin - ICT Startups',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const adminStore = useAdminDataStore()
const projectStore = useProjectStore()
const auth = useAuthStore()
const route = useRoute()

const init = () => {
  globalData.assignPageTitle('Registered Project Details')
  projectStore.retrieveSingleProfile(route.params.uid)
}
onNuxtReady(()=> {
  init()
})

</script>

<template>
  <div class="profile-view-container p-4 max-w-full mx-auto bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-900">{{'' }}</h1>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Basic Information -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">{{ projectStore.getSingleProject?.title }}</h2>
        <div class="mt-2">
          <p><strong>Year:</strong> {{ projectStore.getSingleProject?.year }}</p>
          <p><strong>Category:</strong> {{ projectStore.getSingleProject?.category }}</p>
          <p><strong>Is Verified:</strong>
            <span class="mx-2 text-lg">
              <i v-if="projectStore.getSingleProject?.verify" class="fa-solid fa-circle-check text-green-500"></i>
            <i v-else class="fa-regular fa-circle-xmark text-red-500"></i>
            </span>
          </p>
        </div>
      </div>

      <!-- Location Information -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Description</h2>
        <div class="mt-2">
          <p>{{ projectStore.getSingleProject?.brief }}</p>
        </div>
      </div>

    </div>
  </div>
</template>


<style scoped>
.profile-view-container {
  background-color: #f9fafb; /* Light background */
}
</style>