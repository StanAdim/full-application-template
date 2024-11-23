<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

const props = defineProps({
  headerTitle : {
    default: "Registration",
    type: String
  }
})
const auth = useAuthStore()
const regStore = useRegistrationStore()

const activeTab = ref(1)
const handleTabClick = (index) => {
  activeTab.value = index
}
const user_data = reactive({
  first_name: '',
  middle_name: '',
  last_name: '',
  user_email: '',
  user_phone: '+255',
  password: '',
})

const handleSubmit = async () =>  {
  console.log(props.headerTitle)
  // Handle form submission here
  if (activeTab.value ==  1 ){activeTab.value = 2 }
  else {
    // console.log(user_data)
  }
  let reg_data = {}
  switch (props.headerTitle) {
    case 'ICT Startup':
        reg_data.profile_type = 'startup'
        reg_data = {profile_type : 'startup',...regStore.getStartupData, ...user_data}
      break;
    case 'Innovation Hub':
      reg_data.profile_type = 'hub'
      reg_data = {profile_type : 'hub',...regStore.getHubData, ...user_data}
      break;
    case 'Digital Accelerator':
      reg_data.profile_type = 'accelerator'
      reg_data = {profile_type : 'accelerator',...regStore.getAcceleratorData, ...user_data}
      break;
    case 'Grassroot Program':
      reg_data.profile_type = 'grassroot'
      reg_data = {profile_type : 'grassroot',...regStore.getGrassrootProgramData, ...user_data}
      break;
    default:
      console.log("No profile Selected")
  }
  await auth.register(reg_data)
  // console.log(reg_data)
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
      <div class="flex justify-center mb-4 border-b-2 border-sky-400 w-full max-w-2xl">
        <button
            class="flex-1 py-2 font-semibold"
            :class="[activeTab === 2 ? 'active-tab' : 'text-sky-400']"
            @click="handleTabClick(1)"
        >
          Business Details
        </button>
        <button
            class="flex-1 py-2 font-semibold"
            :class="[activeTab === 1 ? 'active-tab' : 'text-sky-400']"
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
          <UsableBaseInput v-model="user_data.first_name"  placeholder="First name" label="First Name" />
          <UsableBaseInput v-model="user_data.middle_name"  placeholder="Middle name" label="Middle Name" />
          <UsableBaseInput v-model="user_data.last_name"  placeholder="Last name" label="Last Name" />
          <UsableBaseInput v-model="user_data.user_email" type="email"  placeholder="youremail@domain" label="Email" />
          <UsableBaseInput v-model="user_data.user_phone" label="Phone Number" placeholder="+255.." />
          <UsableBaseInput v-model="user_data.password" type="password"  placeholder="********" label="Password" />
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center mt-6">
          <button @click="activeTab = 1" class="text-gray-500 font-semibold flex items-center space-x-2 hover:text-gray-700">
            <span>&larr;</span>
            <span>Go back</span>
          </button>
          <button v-if="activeTab === 1" @click="handleTabClick(2)" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-md flex items-center space-x-2 hover:bg-blue-600">
            <span >Continue</span>
            <span>&rarr;</span>
          </button>
          <button v-else @click="handleSubmit" class="bg-sky-500 text-white font-semibold py-2 px-6 rounded-md flex items-center space-x-2 hover:bg-sky-600">
            <span >Submit <TheBtnLoader /></span>
            <span>&rarr;</span>
          </button>
        </div>
      </div>

    </div>
  </div>
</template>

<style scoped>

</style>