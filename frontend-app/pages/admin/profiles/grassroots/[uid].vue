<script setup lang="ts">
definePageMeta({
  title: 'Admin - Grassroot Program',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const auth = useAuthStore()
const globalData = useGlobalDataStore()
const adminStore = useAdminDataStore()
const route = useRoute()
const config = useRuntimeConfig()


const init = async () => {
  globalData.assignPageTitle('Grassroot Program Details')
  await  adminStore.retrieveSingleProfile('grassroots', route.params.uid)
}
onNuxtReady(() => {
  init()
})
// const imagePath = computed(()=> `${config.public.apiBaseUlr}/${auth.getLoggedUserProfile?.logoPath || ''}`)
const imagePath = computed(()=> `/images/Hubs.png`)
</script>

<template>
  <div class="profile-view-container p-4 max-w-full mx-auto bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center flex-wrap-reverse gap-2">
      <h1 class="text-2xl font-bold text-gray-900"> <small class="text-sm">Name: </small> {{adminStore.getSingleProfile?.name }}</h1>
      <img :src="imagePath"  class="w-20 h-20 md:mr-/10" :alt="imagePath">
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Basic Information -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
        <div class="mt-2">
          <p><strong>Email:</strong> {{ adminStore.getSingleProfile?.email }}</p>
          <p><strong>Phone:</strong> {{ adminStore.getSingleProfile?.phone }}</p>
          <p><strong>Region:</strong> {{ adminStore.getSingleProfile?.region }}</p>
          <p><strong>Date of Establishment:</strong> {{ adminStore.getSingleProfile?.establishmentDate }}</p>
        </div>
      </div>
      <div>
        <!--        Unique Profile Info-->
        <AuthTheGrassrootProgramInfo :data="adminStore.getSingleProfile" />
      </div>
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Description</h2>
        <div class="mt-2">
          <p class="">{{ adminStore.getSingleProfile?.description }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>