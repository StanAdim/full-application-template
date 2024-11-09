<script setup lang="ts">
const props = defineProps({
  headerTitle : {
    default: "Registration",
    type: String
  }
})

const activeTab = ref(1)
const handleTabClick = (index) => {
  activeTab.value = index
}
const user_data = reactive({
  first_name: '',
  middle_name: '',
  last_name: '',
  email: '',
  phone_number: '',
  region: '',
  password: '',
  confirm_password: ''
})

const handleSubmit = () => {
  // Handle form submission here
  if (activeTab.value ==1 ){activeTab.value = 2 }
  else {
    console.log(user_data)
  }
  const regStore = useRegistrationStore()
  switch (props.headerTitle) {
    case 'ICT Startup':
      console.log(regStore.getStartupData)
      break;
    case 'Incubation Hub':
      console.log('Hubs')
      break;
    case 'Digital Accelerator':
      console.log('Accelerators')
      break;
    case 'Grassroot Program':
      console.log('Grassroot')
      break;
    default:
      console.log("No profile Selected")
  }

}
</script>

<template>
  <div class="">
    <div class="flex flex-col items-center justify-center p-6">
      <!-- Header Section -->
      <div class="text-center mb-6">
        <p class="appColor font font-bold text-xl md:text-3xl">{{ props.headerTitle }} Registration</p>
      </div>
      <!-- Tabs Section -->
      <div class="flex justify-center mb-4 border-b border-gray-300 w-full max-w-2xl">
        <button
            class="flex-1 py-2 font-semibold"
            :class="[activeTab === 1 ? 'active-tab' : 'text-gray-400']"
            @click="handleTabClick(1)"
        >
          Business Details
        </button>
        <button
            class="flex-1 py-2 font-semibold"
            :class="[activeTab === 2 ? 'active-tab' : 'text-gray-400']"
            @click="handleTabClick(2)"
        >
          Personal Details
        </button>

        <span class="flex-none py-2 text-gray-400 font-semibold">{{ activeTab }}/2</span>
      </div>

      <!-- Form Section -->
      <div class="w-full max-w-2xl bg-fade rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-0" v-if="activeTab === 1">
          <!-- Input Fields -->
          <slot name="form" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2" v-if="activeTab === 2">
          <!-- Input Fields -->
          <UsableBaseInput v-model="user_data.first_name"  placeholder="first name" label="First Name" />
          <UsableBaseInput v-model="user_data.middle_name"  placeholder="middle name" label="Middle Name" />
          <UsableBaseInput v-model="user_data.last_name"  placeholder="last name" label="Last Name" />
          <UsableBaseInput v-model="user_data.email" type="email"  placeholder="youremail@domain" label="Email" />
          <UsableBaseInput v-model="user_data.phone_number" label="Phone Number" placeholder="+255.." />
          <UsableBaseSelect v-model="user_data.region"  label="Region" :options="regions" />
          <UsableBaseInput v-model="user_data.password" type="password"  placeholder="*************" label="Password" />
          <UsableBaseInput v-model="user_data.confirm_password" type="password"  placeholder="*************" label="Confirm Password" />
        </div>


        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center mt-6">
          <button @click="activeTab = 1" class="text-gray-500 font-semibold flex items-center space-x-2 hover:text-gray-700">
            <span>&larr;</span>
            <span>Go back</span>
          </button>
          <button @click="handleSubmit" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-md flex items-center space-x-2 hover:bg-blue-600">
            <span v-if="activeTab === 1">Continue</span>
            <span v-if="activeTab === 2">Submit</span>
            <span>&rarr;</span>
          </button>
        </div>
      </div>

    </div>
  </div>
</template>

<style scoped>

</style>