<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";
import {useProgrammeStore} from "~/stores/useProgrammeStore";

definePageMeta({
  title: 'Acceleration Programme Registration',
  layout: 'default',
  middleware: 'auth',
});

const globalData = useGlobalDataStore();
const programmeStore = useProgrammeStore();
const genStore = useGeneralStore();

// Reactive form data with default values
const form_data = reactive({
  id: null, // Added for editing purposes
  title: '',
  closing_date: '',
  description: 'Provide a brief description of the Program',
  funding: '',
  owner: '',
  eligibility: [''],  // List of eligibility criteria (initially one input)
  uid: '',
  action: 'create', // Defaults to "create"
});

// Function to initialize form data for editing
const initFormData = (existingData = null) => {
  if (existingData) {
    form_data.id = existingData?.id;
    form_data.title = existingData?.title;
    form_data.closing_date = existingData?.closing_date;
    form_data.description = existingData?.description;
    form_data.funding = existingData?.funding;
    form_data.owner = existingData?.owner;
    form_data.uid = existingData?.uid;
    form_data.eligibility = existingData?.eligibility || [''];  // Default if undefined
    form_data.action = 'update'; // Set action to "edit"
    globalData.assignPageTitle('Edit Acceleration Programme');
  } else {
    globalData.assignPageTitle('Register New Acceleration Programme');
  }
};

// Handle form submission for both creation and editing
const handleForm = async () => {
  await programmeStore.createUpdateProgramme(form_data);
  // console.log(form_data.valueOf())
};

// Initialize the form when the page is ready
onNuxtReady(() => {
  const existing = programmeStore.getSingleProgramme; // Example: Fetch project for editing
  initFormData(existing);
});

// Handle adding new input field
const addInput = () => {
  form_data.eligibility.push('');  // Add a new empty string to eligibility list
};

// Handle removing an input field
const removeInput = (index: number) => {
  form_data.eligibility.splice(index, 1);
  // Ensure at least one input remains
  if (form_data.eligibility.length === 0) {
    form_data.eligibility.push('');
  }
};
</script>

<template>
  <div>
    <div class="info">
      <div></div>
    </div>
    <div class="flex">
      <div class="forms">
        <form @submit.prevent="handleForm">
          <div>
            <div class="form-groups">
              <UsableBaseInput
                  placeholder="Title..."
                  v-model="form_data.title"
                  label="Programme title"
              />
              <UsableBaseInput
                  placeholder="Closing Date"
                  type="date" v-model="form_data.closing_date"
                  label="Closing Date" />
            </div>
            <div class="form-groups">
              <UsableBaseInput
                  placeholder="Funding..."
                  type="number"
                  v-model="form_data.funding"
                  label="Programme Funding (TSH)"
              />
              <UsableBaseInput
                  placeholder="Programme Owner"
                  v-model="form_data.owner"
                  label="Programme Owner" />
            </div>

            <UsableBaseTextArea
                placeholder="Provide a brief description..."
                v-model="form_data.description"
                label="Brief Description"
            />

            <div class="title text-lg my-2"> Programme Eligibility
              <span @click="addInput"
                    class="text-xs font-bold hover:cursor-pointer text-sky-600 px-1 py-0.5 rounded-md">
                Add <i class="fa-solid fa-plus"></i></span>
            </div>

            <!-- Loop through the eligibility list and create input fields dynamically -->
            <div class="flex gap-2" v-for="(input, index) in form_data.eligibility" :key="index">
              <UsableBaseInput
                  placeholder="Eligibility"
                  v-model="form_data.eligibility[index]"
              :label="`Eligibility ${index + 1}`" />
              <button
                  @click="removeInput(index)"
                  class="mx-4 text-red-600 pt-2 text-lg"
                  type="button"
              >
                <i class="fa-solid fa-trash-can"></i>
              </button>
            </div>

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
/* Scoped styles for your component */
</style>
