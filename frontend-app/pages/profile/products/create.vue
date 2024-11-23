<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

definePageMeta({
  title: 'Product Registration',
  layout: 'default',
  middleware: 'auth',
});

const globalData = useGlobalDataStore();
const productStore = useProductStore();
const genStore = useGeneralStore();

// Reactive form data with default values
const form_data = reactive({
  id: null, // Added for editing purposes
  name: '',
  category: 1,
  is_launched: 1,
  launched_date: '',
  description: 'Provide a brief description of the Product',
  technicalSpecs: '',
  targetAudience: '',
  intellectualProp: '',
  supportingMedia: [''],
  users_impression: '',
  compliance_details: '',
  uid: '',
  action: 'create', // Defaults to "create"
});

// Function to initialize form data for editing
const initFormData = (existingData = null) => {
  if (existingData) {
    form_data.id = existingData.id;
    form_data.name = existingData.name;
    form_data.is_launched = existingData.is_launched;
    form_data.launched_date = existingData.launched_date;
    form_data.description = existingData.description;
    form_data.compliance_details = existingData.compliance_details;
    form_data.users_impression = existingData.users_impression;
    form_data.category = existingData.category;
    form_data.uid = existingData.uid;
    form_data.action = 'update'; // Set action to "edit"
    globalData.assignPageTitle('Edit Product');
  } else {
    globalData.assignPageTitle('Register New Product');
  }
};

const supportingMedia = ref([{ mediaLink: '' }]);

// Handle form submission for both creation and editing
const handleForm = async () => {
  await productStore.createUpdateProduct(form_data);
  // console.log(form_data)
};
const init = async () => {
  await Promise.all(
      [
        genStore.retrieveSectors(),
      ]
  )
}
// Initialize the form when the page is ready
onNuxtReady(() => {
  const existingProduct = productStore.getSingleProduct; // Example: Fetch project for editing
  initFormData(existingProduct);
  init()
});
</script>

<template>
  <div>
    <div class="info">
      <div></div>
    </div>
    <div class="flex">
      <div class="forms">
        <form @submit.prevent="handleForm" class="">
          <div>
            <div class="form-groups">
              <UsableBaseInput
                  :is-full="true"
                  placeholder="Product name..."
                  v-model="form_data.name"
                  label="Product Name"
              />
              <div class="">
                <p class="block text-gray-600 text-sm font-semibold mb-1" >Category | Sector</p>
                <el-select
                    v-model="form_data.category"
                    multiple
                    collapse-tags
                    size="large"
                    placeholder="Select"
                    style="width: 300px"
                >
                  <el-option
                      v-for="item in genStore.getSectors"
                      :key="item.value"
                      :label="item.label"
                      :value="item.value"
                  />
                </el-select>
              </div>

            </div>
            <UsableBaseTextArea
                placeholder="Provide a brief description..."
                v-model="form_data.description"
                label="Brief Description"
            />
           <div class="form-groups">
            <div class="">
              <el-form-item class="block text-gray-600 text-sm font-semibold mb-1" label="Is a Launched Product">
                <el-radio-group v-model="form_data.is_launched">
                  <el-radio :value="true">Yes</el-radio>
                  <el-radio :value="false">No</el-radio>
                </el-radio-group>
              </el-form-item>
            </div>
             <div class="" v-if="form_data.is_launched">
               <UsableBaseInput placeholder="Choose Date" type="date" v-model="form_data.launched_date" label="Launch Date" />
             </div>

           </div>
            <div class="title text-lg mb-2">Impact and Usage Metrics</div>
            <UsableBaseInput  :is-full="false" placeholder="1"  type="number" v-model="form_data.users_impression"  label="Number of Users"  />

            <div class="title text-lg mb-2">Legal and Compliance Information</div>
            <UsableBaseTextArea  placeholder="E.g., BRELA registration, etc" v-model="form_data.compliance_details"  label="Compliance Details"  />

            <button
                class="bg-sky-500 text-white font-semibold py-1 px-4 rounded-md flex items-center space-x-2 hover:bg-sky-600"
            >
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
</template>


<style scoped>

</style>