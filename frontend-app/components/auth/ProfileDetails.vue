<script setup lang="ts">
const auth = useAuthStore()
const config = useRuntimeConfig()
const imagePath = computed(()=> `${config.public.apiBaseUlr}/${auth.getLoggedUserProfile?.logoPath || ''}`)
</script>

<template>
  <div class="profile-view-container p-4 max-w-full mx-auto bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center flex-wrap-reverse gap-2">
      <h1 class="text-2xl font-bold text-gray-900">{{auth.getUserProfileable?.name }}</h1>
      <img :src="imagePath"  class="w-20 h-20" alt="">
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Basic Information -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
        <div class="mt-2">
          <p><strong>Email:</strong> {{ auth.getLoggedUserProfile?.email }}</p>
          <p><strong>Phone:</strong> {{ auth.getLoggedUserProfile?.phone }}</p>
          <p><strong>Region:</strong> {{ auth.getLoggedUserProfile?.region }}</p>
          <p><strong>Date of Establishment:</strong> {{ auth.getLoggedUserProfile?.establishmentDate }}</p>
        </div>
      </div>
      <div>
<!--        Unique Profile Info-->
        <AuthTheStartupInfo v-if="auth.getProfileCategoryName  === 'ICT Startup'"  />
        <AuthTheHubInfo v-if="auth.getProfileCategoryName  === 'Innovation Hub'" />
        <AuthTheAcceleratorInfo v-if="auth.getProfileCategoryName  === 'Digital Accelerator'" />
        <AuthTheGrassrootProgramInfo v-if="auth.getProfileCategoryName  === 'Grassroot Program'" />
      </div>
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Description</h2>
        <div class="mt-2">
          <p class="">{{ auth.getUserProfileable?.description }}</p>
        </div>
      </div>
    </div>
  </div>

</template>

<style scoped>

</style>