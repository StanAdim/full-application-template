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
const per_page = ref <number>(10)
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
const headers = ref(['Sn', 'Title', "Category" , "Year" , 'Approved', 'Registration Date', 'Actions'])
const OpenConfirmDialog = async (uid) => {
  await ElMessageBox.confirm(
      'This project will be permanently deleted. Continue?',
      'Warning',

      {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
        distinguishCancelAndClose:true
      }
  )
      await globalData.deleteItemInDB( uid, 'project')
      .then(() => {
        ElMessage({
          type: 'success',
          message: 'Delete completed',
        })
        console.log("Deleted")
      })
      .catch(() => {
        ElMessage({
          type: 'info',
          message: 'Delete canceled',
        })
      })
}
const handleAction = async  (type, uid) => {
  switch (type){
    case 1: {
      navigateTo(`/profile/projects/project/${uid}`)
      break;
    }
    case 2: {
      await projectStore.retrieveSingleProfile(uid)
      navigateTo(`/profile/projects/create`)
      break;
    }
    case 3: {
      await  OpenConfirmDialog(uid)
      break;
    }
  }

}
// initialize
const init = async () =>  {
  globalData.assignPageTitle('Projects registered')
  await projectStore.retrieveAllProjects(per_page.value,currentPage.value, searchQuery.value)
  console.log(projectStore.getAllProjects.length)
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
          <tr v-if="projectStore.getAllProjects?.length != 0"
              v-for="(item, index) in projectStore.getAllProjects"
              :key="item.uid"
              class="hover:bg-sky-100">
            <td class="table-data">{{ index + 1 }}</td>
            <td class="table-data">{{ item?.title }}</td>
            <td class="table-data">{{ item?.category }}</td>
            <td class="table-data">{{ item?.year }}</td>
            <td class="table-data">
              <span class="mx-2 text-lg">
              <i v-if="item?.status" class="fa-solid fa-circle-check text-green-500"></i>
              <i v-else class="fa-regular fa-circle-xmark text-red-500"></i>
            </span>
            </td>
            <td class="table-data">{{ item?.registrationDate }}</td>
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
          <tr v-else class="text-center font-bold">No Data Found</tr>
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
                      class="text-sky-800 w-12 h-8 text-center border rounded-lg border-sky-400 px-0.5 py-0 outline-none"
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

.search-input{
  @apply border border-gray-300 rounded-md px-4 h-8 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500;
}
.action-btn {
  @apply px-3 py-2 border border-sky-300 rounded-md text-sm font-medium text-gray-500 hover:bg-sky-100
}
</style>