<script setup lang="ts">
// Page metadata definition
definePageMeta({
  title: 'User Dashboard',
  layout: 'default',
  middleware: 'auth',
})

// Global state and reactive data setup
const globalData = useGlobalDataStore()
const projectsCount = ref('...')
const productsCount = ref('...')

const dataItems = computed(() => [
  { title: 'All Products', path: '/profile/products', size: productsCount.value },
  { title: 'All Projects', path: '/profile/projects', size: projectsCount.value },
])

const dashCardItems = computed(() => [
  { title: 'ICT Products', description: 'ICT products are tangible or intangible solutions developed using technology to address specific problems, enhance efficiency, or create value. They include software applications, hardware devices, and digital platforms like mobile apps, IoT systems, and e-commerce sites.' },
  { title: 'ICT Projects', description: ' ICT projects are structured initiatives focused on planning, developing, and implementing ICT solutions within a defined scope, timeline, and budget. These projects aim to create or deploy products or systems, such as building cloud-based infrastructures, developing enterprise resource planning software, or implementing national e-government platforms.'},
])
// Initialization function to fetch counts and set the page title
const init = async () => {
  globalData.assignPageTitle('Dashboard')
  const [projects, products] = await Promise.all([
    globalData.statsOfItem('projects'),
    globalData.statsOfItem('products'),
  ])
  projectsCount.value = projects
  productsCount.value = products
}

// Lifecycle hook to initialize the component
onNuxtReady(()=>{
  init()
})
</script>

<template>
  <div>
    <div class="flex flex-col lg:flex-row gap-4 my-2 py-2">
      <AuthWildCard
          v-for="item in dataItems"
          :key="item.path"
          :title="item.title"
          :path="item.path"
          :size="item.size"
      />
    </div>
    <div class="flex flex-col lg:flex-row gap-4 my-2 py-2">
      <AuthDashCard
          v-for="item in dashCardItems"
          :key="item.path"
          :title="item.title"
          :description="item.description"
      />
    </div>

  </div>
</template>

<style scoped></style>
