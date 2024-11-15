<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  middleware:'auth',
})
const globalData = useGlobalDataStore()
const projectStore = useProjectStore()

const currentPage = ref <number>(1)
const per_page = ref <number>(30)
const searchQuery = ref('')
const pageSwitchValue = ref(1)
const movePage = async (type:number) => {
  console.log(type)
  if (type === 1){
    currentPage.value = currentPage.value + pageSwitchValue.value
  }else {
    currentPage.value = currentPage.value - pageSwitchValue.value
  }
  await projectStore.retrieveAllProjects(per_page.value,currentPage.value)
}
// change page number
const  isEditing = ref(false)
const toggleEditing =  () => isEditing.value = !isEditing.value
const  updateData = async () => {
  await projectStore.retrieveAllProjects(per_page.value,currentPage.value)
}
const  searchUserData = async () => {
  await projectStore.retrieveAllProjects(per_page.value,currentPage.value, searchQuery.value)
}
const headers = ref(['Sn', 'Title', "Category" , "Year" , 'Approved', 'Actions'])

const handleAction = async  (type, uid) => {
  console.log(type,uid)
  switch (type){
    case 1: {
      console.log('View')
      break;
    }
    case 2: {
      console.log('Edit')
      break;
    }
    case 3: {
      console.log('Delete')
      break;
    }
  }

}
// initialize
const init = async () =>  {
  globalData.assignPageTitle('Registered Projects List')
  await projectStore.retrieveAllProjects(per_page.value,currentPage.value, searchQuery.value)
}
onNuxtReady(()=> {
  init()
})

</script>

<template>
  <div class="mt-2">
    <div class="flex justify-end items-center gap-2 mb-2 mx-4">
      <UsableNewFeatureBtn @click.prevent="navigateTo('/profile/projects/create')" :is-normal="true" name="Add New" iconClass="fa-solid fa-plus" />
      <div class="">
        <input
            v-model="searchQuery"
            @keyup.enter="searchUserData"
            type="text"
            placeholder="Search..."
            class="search-input"
        />
      </div>
    </div>
    <div class="w-full  py-2">
      <!-- Scrollable Table -->
      <div class="overflow-auto rounded-lg shadow-lg">
        <table class="w-full bg-white rounded-lg overflow-x-auto">
          <thead class="bg-sky-600 ">
          <tr>
            <th
                v-for="header in headers"
                :key="header"
                class="px-2 py-3 text-left font-bold text-xs text-white uppercase tracking-wider"
            >
              {{ header }}
            </th>
          </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          <tr
              v-for="(item, index) in projectStore.getAllProjects"
              :key="item.id"
              class="hover:bg-sky-100">
            <td class="table-data">{{ index + 1 }}</td>
            <td class="table-data">{{ item?.title }}</td>
            <td class="table-data">{{ item?.category }}</td>
            <td class="table-data">{{ item?.year }}</td>
            <td class="table-data">
              <span  class="text-green-600 px-2" v-if="item.verify"><i class="fa-regular fa-circle-dot"></i></span>
              <span class="text-red-600 px-2" v-else><i class="fa-regular fa-circle-dot"></i></span>
            </td>
            <td class="table-data">
              <el-dropdown size="default" type="primary" placement="bottom-start">
                <el-button><i class="fa-solid fa-prescription-bottle mr-1"></i> Action </el-button>
                <template #dropdown>
                  <el-dropdown-menu>
                    <el-dropdown-item  @click.prevent="handleAction(1, item.uid)" ><i class="fa-solid fa-eye"></i> View</el-dropdown-item>
                    <el-dropdown-item @click.prevent="handleAction(2, item.uid)"  ><i class="fa-regular fa-pen-to-square"></i> Edit</el-dropdown-item>
                    <el-dropdown-item  @click.prevent="handleAction(3, item.uid)" ><i class="fa-solid fa-trash-can"></i> Delete</el-dropdown-item>
                  </el-dropdown-menu>
                </template>
              </el-dropdown>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center mt-4">
        <nav aria-label="Page navigation">
          <ul class="inline-flex space-x-2">
            <li>
              <button
                  @click="movePage(2)"
                  class="action-btn"
              >
                Previous <TheBtnLoader />
              </button>
            </li>
            <li>
              <div class="flex justify-center flex-row gap-2">
                <div class="">Per page</div>
                <div class="">
                  <input
                      v-model="per_page"
                      @blur="toggleEditing"
                      @keyup.enter="updateData"
                      class="text-sky-800 w-16 text-center border-b-2 border-sky-500 rounded-sm px-0.5 outline-none"
                  />
                </div>
              </div>

            </li>
            <li>
              <button
                  @click="movePage(1)"
                  class="action-btn"
              >
                Next <TheBtnLoader />
              </button>
            </li>
          </ul>
        </nav>
      </div>    </div>
  </div>
</template>

<style scoped>
.table-data {
  @apply px-4 py-1.5 whitespace-nowrap text-sm text-gray-700
}
.btn{
  @apply px-2 py-0.5 mx-0.5 text-sm border border-sky-500 hover:border-sky-700
}
.search-input{
  @apply border border-gray-300 rounded-md px-4 py-0 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500;
}
.action-btn {
  @apply px-3 py-2 border border-sky-300 rounded-md text-sm font-medium text-gray-500 hover:bg-sky-100
}
</style>