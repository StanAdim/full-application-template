<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  middleware:'auth',
})
const globalData = useGlobalDataStore()
const projectStore = useProjectStore()
const init = () => {
  globalData.assignPageTitle('Register new project')
}
onNuxtReady(()=> {
  init()
})
const sectors = [
  {label: 'Artificial Intelligence', value : '1'},
  {label: 'WebDev', value : '2'},
]
const form_data = reactive({
  'title' : '',
  'year' : '',
  'brief' : '',
  'category' : '',
  'action': 'create'
})
const  handleForm = async ()=> {
      await projectStore.createUpdateProject(form_data)
      // console.log(form_data)
}
</script>

<template>
  <div class="">
    <div class="info">
      <div class=""></div>
    </div>
    <div class="flex">
        <div class="forms">
          <form @submit.prevent="handleForm" class="">
              <div class="div">
                <UsableBaseInput :is-full="false" placeholder="..." v-model="form_data.title" label="Project Title" />
                <UsableBaseSelect :is-full="false"  placeholder="..." v-model="form_data.year"  label="Year" :options="globalData.getYearsArray" />
                <UsableBaseSelect :is-full="false"  placeholder="..." v-model="form_data.category"  label="Category" :options="sectors" />
                <UsableBaseTextArea  placeholder="..." v-model="form_data.brief"  label="Brief Description"  />
                <button class="bg-sky-500 text-white font-semibold py-1 px-4 rounded-md flex items-center space-x-2 hover:bg-sky-600">
                  <span >Register <TheBtnLoader /></span><i class="fa-solid fa-floppy-disk"></i></button>
              </div>
          </form>
        </div>
    </div>
  </div>
</template>


<style scoped>

</style>