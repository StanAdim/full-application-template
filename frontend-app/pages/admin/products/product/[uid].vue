<script setup lang="ts">
definePageMeta({
  title: 'Admin - ICT Startups',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const adminStore = useAdminDataStore()
const globalData = useGlobalDataStore()
const productStore = useProductStore()
const auth = useAuthStore()
const route = useRoute()

const init = () => {
  globalData.assignPageTitle('Product Details')
  productStore.retrieveSingleProduct(route.params.uid)
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
        <h2 class="text-lg font-semibold text-gray-800">{{ productStore.getSingleProduct?.name }}</h2>
        <div class="mt-2">
          <p><strong>Category:</strong></p>
          <ul>
            <li v-for="item in productStore.getSingleProduct?.category" :key="item">
              {{ item }}
            </li>
          </ul>
          <p><strong>Is Verified:</strong>
            <span class="mx-2 text-lg">
              <i v-if="productStore.getSingleProduct?.status" class="fa-solid fa-circle-check text-green-500"></i>
            <i v-else class="fa-regular fa-circle-xmark text-red-500"></i>
            </span>
          </p>
          <p><strong>Compliance Details:</strong> <br class="p-0 m-0" /> {{ productStore.getSingleProduct?.compliance_details }}</p>
        </div>
      </div>

      <!-- Location Information -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Description</h2>
        <div class="mt-2">
          <p>{{ productStore.getSingleProduct?.description }}</p>
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