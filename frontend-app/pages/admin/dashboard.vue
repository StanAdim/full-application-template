<script setup lang="ts">
import {useGeneralStore} from "~/stores/useGeneralStore";

definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const genStore = useGeneralStore()

const projectsCount = ref('...')
const productsCount = ref('...')

const dataItems = computed(() => [
  { title: 'ICT Startups', path: '/admin/profiles/startups', size: genStore.getStartupsCount },
  { title: 'ICT Innovation Hubs', path: '/admin/profiles/hubs', size: genStore.getHubsCount },
  { title: 'Digital Accelerators', path: '/admin/profiles/accelerators', size: genStore.getAcceleratorsCount },
  { title: 'Grassroot Programs', path: '/admin/profiles/grassroots', size: genStore.getGrassrootsCount },
  { title: 'All Products', path: '/admin/products', size: productsCount.value },
  { title: 'All Projects', path: '/admin/projects', size: projectsCount.value },
])
const init = async () => {
  globalData.assignPageTitle('Admin Dashboard')
  const [projects, products] = await Promise.all([
    globalData.statsOfItem('projects'),
    globalData.statsOfItem('products'),
    genStore.retrieveProfileCount('startups'),
    genStore.retrieveProfileCount('hubs'),
    genStore.retrieveProfileCount('accelerators'),
    genStore.retrieveProfileCount('grassroots')
  ])
  projectsCount.value = projects
  productsCount.value = products
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 my-2 py-2 bg-sky-50 px-2">
      <AuthWildCard
          v-for="item in dataItems"
          :key="item.path"
          :title="item.title"
          :path="item.path"
          :size="item.size"
      />
    </div>

  </div>
</template>

<style scoped></style>
