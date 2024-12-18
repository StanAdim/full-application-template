<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

definePageMeta({
  title: 'Document upload',
  layout: 'default',
  middleware: 'auth',
});

const globalData = useGlobalDataStore();
const documentStore = useDocumentStore();
const auth = useAuthStore();


// Form inputs
const formInputs = ref({
  file: null,  // Ensure file is initialized as null or a File object
  name: '',
  type_id: 1,
  profile_id: '',
});
// Handle file change
const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    formInputs.value.file = target.files[0];
    // formInputs.value.file = URL.createObjectURL(target.files[0]);
  }
};

const handleFileUpload = async () => {
  if (!formInputs.value.file) {
    const message = 'Please select a file to upload.';
    globalData.assignAlertMessage(message, 'warning');
    return;
  }

  // Create FormData
  const formData = new FormData();
  formData.append('document', formInputs.value.file);
  formData.append('name', formInputs.value.name);
  formData.append('type_id', formInputs.value.type_id);
  formData.append('profile_id', auth.getLoggedUserProfile?.uid);
  // Log the form data contents for debugging
  // for (let [key, value] of formData.entries()) {
  //   console.log(`${key}:`, value);
  // }
  globalData.toggleBtnLoadingState(true)
  await documentStore.uploadNewDocument(formData)
  // console.log(formData)
};

const init = async () => {
  await Promise.all(
      [
        documentStore.retrieveDocumentTypes(),
      ]
  )
}
// Initialize the form when the page is ready
onNuxtReady(() => {
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
        <form @submit.prevent="handleFileUpload" class="">
          <div>
            <div class="form-groups">
              <UsableBaseInput
                  :is-full="true"
                  placeholder="Document name..."
                  v-model="formInputs.name"
                  label="Document Name"
              />
              <UsableBaseSelect
                  placeholder="..."
                  v-model="formInputs.type_id"  label="Document type" :options="documentStore.getDocTypes" />
            </div>
            <div class="mb-4">
              <label for="documentFile" class="block text-sm font-medium text-gray-700 mb-2">Document File</label>
              <input type="file"
                     accept="application/pdf"
                     @change="handleFileChange" id="documentFile"
                     class="w-full bg-gray-300 rounded-r-md border-none">
            </div>

            <button
                class="bg-sky-500 text-white font-semibold py-1 px-4 rounded-md flex items-center space-x-2 hover:bg-sky-600">
              <span class="px-1">Upload</span> <TheBtnLoader /> <i class="fa-solid fa-floppy-disk px-1"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>


<style scoped>
</style>