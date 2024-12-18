<script setup lang="ts">
import {useProductStore} from "~/stores/useProductStore";
import {useProgrammeStore} from "~/stores/useProgrammeStore";

definePageMeta({
  title: 'Programme Details',
  layout: 'default',
  middleware:'auth',
})
const globalData = useGlobalDataStore()
const progStore = useProgrammeStore()
const auth = useAuthStore()
const route = useRoute()
const init = () => {
  globalData.assignPageTitle('Programme Details')
  progStore.retrieveSingleProgramme(route.params.uid)
}
onNuxtReady(()=> {
  init()
})

</script>

<template>
  <div class="profile-view-container p-4 max-w-full mx-auto bg-white rounded-lg shadow-md">
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Basic Information -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">{{ progStore.getSingleProgramme?.title }}</h2>
        <div class="mt-2">
          <p><strong>Approved:</strong>
            <span class="mx-2 text-lg">
              <i v-if="progStore.getSingleProgramme?.status" class="fa-solid fa-circle-check text-green-500"></i>
              <i v-else class="fa-regular fa-circle-xmark text-red-500"></i>
            </span>
          </p>
          <p><strong>Closing Date:</strong><span class="mx-2 "> {{progStore.getSingleProgramme?.closing_date}}</span></p>
          <p><strong>Owner:</strong><span class="mx-2 "> {{progStore.getSingleProgramme?.owner }}</span></p>
          <p><strong>Created By:</strong><span class="mx-2 "> {{progStore.getSingleProgramme?.user }}</span></p>
          <p><strong>Registered By:</strong><span class="mx-2 "> {{progStore.getSingleProgramme?.registrationDate }}</span></p>
        </div>
      </div>

      <!-- Other -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Description</h2>
        <div class="mt-0">
          <p>{{ progStore.getSingleProgramme?.description }}</p>
        </div>
      </div>
      <div class="">
        <p><strong>Eligibility:</strong></p>
        <ul>
          <li v-for="(item , index) in progStore.getSingleProgramme?.eligibility" :key="item">
            <span class="font-bold">{{index + 1}}. </span>{{ item }}
          </li>
        </ul>
      </div>


    </div>
    <div class="" v-if="globalData.hasPermission('view_programme_applicants')">
      <h2 class="text-lg font-semibold text-gray-800">Applications</h2>
      <AuthProgrammeApplicationsTable :table-data="progStore.getSingleProgramme?.applications " />

    </div>
  </div>
</template>


<style scoped>
.profile-view-container {
  background-color: #f9fafb; /* Light background */
}
</style>