<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

const documentStore = useDocumentStore()
const  form_data = reactive({
  action: 'create',
  name: ''
})
const handleForm = async  ()=> {
  await  documentStore.createUpdateDocumentType(form_data)
}
const handleDelete = async  (passed_item)=> {
  await  documentStore.deleteDocType(passed_item?.value)
  // console.log(passed_item)
}

</script>

<template>
    <div class="mx-2">
      <div class="bg-white rounded-md px-2">
        <div class="">
          <h2 class="text-lg font-bold py-1 px-2">Document Types</h2>
          <div class="grid grid-cols-2 mx-2">
            <div class="list">
              <div class="font-bold">Registered Document types</div>
              <ul class="px-2 py-0 my-0">
                <li class="text-red-900" v-if="documentStore.getDocTypes?.length === 0">No data found <i class="fa-regular fa-hourglass"></i></li>
                <li class="text-gray-950 bg-sky-100 my-1 px-3 rounded-sm"
                    v-else v-for="(item, index) in  documentStore.getDocTypes"
                    :key="index">
                  <div class="flex justify-between ">
                    <div class=""><span class="">{{index + 1 }}</span>. {{item?.label}}</div>
                    <div class="">
                      <button @click.prevent="handleDelete(item)"
                              class="bg-red-600 hover:bg-red-400 text-white rounded-full text-sm hover:text-black px-2 py-1 mx-1">
                        <i class="fa-solid fa-trash-can"></i>
                      </button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="create">
              <div class="font-bold">Register new types</div>
              <div class="forms">
                <form @submit.prevent="handleForm" class="">
                  <div>
                    <UsableBaseInput
                        :is-full="false"
                        placeholder="Document Type name..."
                        v-model="form_data.name"
                        label="Document Type Name"
                    />
                    <button class="bg-sky-500 text-white font-semibold py-1 px-4 rounded-md flex items-center space-x-2 hover:bg-sky-600">
                      <span>
                        {{ form_data.action === 'create' ? 'Register' : 'Update' }}
                        <TheBtnLoader />
                      </span>
                      <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<style scoped>

</style>