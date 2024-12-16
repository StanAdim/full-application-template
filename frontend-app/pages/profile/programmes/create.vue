<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

definePageMeta({
  title: 'Acceleration Programme Registration',
  layout: 'default',
  middleware: 'auth',
});

const globalData = useGlobalDataStore();
const productStore = useProductStore();
const genStore = useGeneralStore();

// Reactive form data with default values
const form_data = reactive({
  id: null, // Added for editing purposes
  title: '',
  category: 1,
  is_launched: 1,
  launched_date: '',
  description: 'Provide a brief description of the Program',
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
    form_data.title = existingData.title;
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
    globalData.assignPageTitle('Register New Acceleration Programme');
  }
};

const supportingMedia = ref([{ mediaLink: '' }]);

// Handle form submission for both creation and editing
const handleForm = async () => {
  if(!form_data.is_launched) form_data.launched_date = null
  await productStore.createUpdateProduct(form_data);
  // console.log(form_data.is_launched, form_data.launched_date)
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
                  placeholder="Title..."
                  v-model="form_data.title"
                  label="Programme title"
              />

            </div>
            <UsableBaseTextArea
                placeholder="Provide a brief description..."
                v-model="form_data.description"
                label="Brief Description"
            />
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