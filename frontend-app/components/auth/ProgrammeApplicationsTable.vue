<script setup lang="ts">

const props  = defineProps({
  tableData : {
    default: [],
    type: Array
  }
})
const progStore = useProgrammeStore()

const currentPage = ref <number>(1)
const per_page = ref <number>(10)
const searchQuery = ref('')
const pageSwitchValue = ref(1)
const movePage = async (type:number) => {
  if (type === 1){
    currentPage.value = currentPage.value + pageSwitchValue.value
  }else {
    currentPage.value = currentPage.value - pageSwitchValue.value
  }
  await progStore.retrieveAllProgrammes(per_page.value,currentPage.value)
}
// change page number
const  isEditing = ref(false)
const toggleEditing =  () => isEditing.value = !isEditing.value
const  updateData = async () => {
  await progStore.retrieveAllProgrammes(per_page.value,currentPage.value)
}
// const  searchUserData = async () => {
//   await progStore.retrieveAllProgrammes(per_page.value,currentPage.value, searchQuery.value)
// }
const headers = ref(['Sn', "Entity type" ,"Entity Name", "Entity Email", "Entity Phone", 'Status', 'Applied on', 'Actions'])

</script>

<template>
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
        <tr v-if="props.tableData?.length != 0"
            v-for="(item, index) in props.tableData"
            :key="item.uid"
            class="hover:bg-sky-100">
          <td class="table-data">{{ index + 1 }}</td>
          <td class="table-data">{{ item?.profile?.profileable?.type }}</td>
          <td class="table-data">{{ item?.profile?.profileable?.name }}</td>
          <td class="table-data">
            <span class="mx-2">{{ item?.profile?.email }}</span>
          </td>
          <td class="table-data">
            <span class="mx-2">{{ item?.profile?.phone }}</span>
          </td>
          <td class="table-data">
              <span class="mx-2">{{ item?.status }}</span>
          </td>

          <td class="table-data">{{ item?.applied_on }}</td>
          <td class="table-data">
            <el-dropdown size="default" type="primary" placement="bottom-start">
              <el-button><i class="fa-solid fa-prescription-bottle mr-1"></i> Action </el-button>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item  @click.prevent="console.log(1, item.uid)" ><i class="fa-solid fa-eye"></i> View</el-dropdown-item>
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
          <li><button @click="movePage(2)"  class="action-btn" > Previous <UsableTheBtnLoader /></button></li>
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
            <button @click="movePage(1)" class="action-btn" >Next <TheBtnLoader /></button>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<style scoped>

</style>