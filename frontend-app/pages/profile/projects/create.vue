<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  middleware: 'auth',
});

const globalData = useGlobalDataStore();
const projectStore = useProjectStore();
const genStore = useGeneralStore();


const sectors = [
  { label: 'Artificial Intelligence', value: '1' },
  { label: 'WebDev', value: '2' },
];

// Reactive form data with default values
const form_data = reactive({
  id: null, // Added for editing purposes
  title: '',
  year: 2020,
  brief: '',
  category: 1,
  action: 'create', // Defaults to "create"
});

// Function to initialize form data for editing
const initFormData = (existingData = null) => {
  if (existingData) {
    form_data.id = existingData.id;
    form_data.title = existingData.title;
    form_data.year = existingData.year;
    form_data.brief = existingData.brief;
    form_data.category = existingData.category;
    form_data.uid = existingData.uid;
    form_data.action = 'update'; // Set action to "edit"
    globalData.assignPageTitle('Edit Project');
  } else {
    globalData.assignPageTitle('Register New Project');
  }
};

// Handle form submission for both creation and editing
const handleForm = async () => {
  await projectStore.createUpdateProject(form_data);
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
  const existingProject = projectStore.getSingleProject; // Example: Fetch project for editing
  initFormData(existingProject);
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
            <UsableBaseInput
                :is-full="false"
                placeholder="Enter project title..."
                v-model="form_data.title"
                label="Project Title"
            />
            <UsableBaseSelect
                :is-full="false"
                placeholder="Select year..."
                v-model="form_data.year"
                label="Initiation Year"
                :options="globalData.getYearsArray"
            />
            <UsableBaseSelect
                :is-full="false"
                placeholder="Select category..."
                v-model="form_data.category"
                label="Category"
                :options="genStore.getSectors"
            />
            <UsableBaseTextArea
                placeholder="Provide a brief description..."
                v-model="form_data.brief"
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