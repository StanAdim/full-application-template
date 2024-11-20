<script setup lang="ts">
import {useGeneralStore} from "~/stores/useGeneralStore";

definePageMeta({
  layout: 'landing',
  // middleware:'guest'
})
useHead({
  title: 'Registered Profiles',
})
const globalData = useGlobalDataStore()
const genStore = useGeneralStore()
const dataItems = computed(() => [
  { title: 'ICT Startups', path: '/profiles/startups', count: genStore.getStartupsCount },
  { title: 'ICT Innovation Hubs', path: '/profiles/hubs', count: genStore.getHubsCount },
  { title: 'Digital accelerators', path: '/profiles/accelerators', count: genStore.getAcceleratorsCount },
  { title: 'Grassroot Programs', path: '/profiles/grassroots', count: genStore.getGrassrootsCount },
])
const init = async  () => {
  await Promise.all(
     [
       genStore.retrieveProfileCount('startups'),
       genStore.retrieveProfileCount('hubs'),
       genStore.retrieveProfileCount('accelerators'),
       genStore.retrieveProfileCount('grassroots')
     ]
  )
}
onNuxtReady(()=> {
  init()
})
</script>
<template>
  <div class="container mx-auto">
    <div class="md:h-[60vh] py-2 mx-2">
      <div class="bg-sky-50 py-8 pt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-sky-900 sm:text-4xl">
              Tanzania ICT Startups, ICT Innovation Hubs and Accelerator Ecosystem
            </h2>
            <p class="mt-3 text-xl text-sky-500 sm:mt-4">
              An ICT startup ecosystem fosters innovation, collaboration, and growth through technology, entrepreneurship, funding, and supportive networks
            </p>
          </div>
        </div>
        <div class="mt-10 pb-1">
          <div class="relative">
            <div class="bg-sky-50"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div class="max-w-4xl mx-auto">
                <dl class="rounded-lg bg-white shadow-lg sm:grid sm:grid-cols-4">

                  <GuestMinorProfileCard
                      v-for="item in dataItems"
                      :key="item.path"
                      :title="item.title"
                      :path="item.path"
                      :count="item.count" />
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
