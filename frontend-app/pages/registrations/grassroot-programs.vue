<script setup lang="ts">
import RegistrationFrame from "~/components/usable/RegistrationFrame.vue";

definePageMeta({
  title: 'Register',
      layout: 'guest',
})
const globalData = useGlobalDataStore()
const regions = [{  label : 'Arusha', value: '1'}, ]
const activeTab = ref(1)
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
const entity_data = reactive({
  name: '',
  founders: '',
  email: '',
  phone_number: '',
  website: '',
  industry: ''
})

const handleTabClick = (index) => {
  activeTab.value = index
}

const handleSubmit = () => {
  // Handle form submission here
  if (activeTab.value ==1 ){activeTab.value = 2 }
  else {
    console.log(user_data, entity_data)
  }
}
</script>

<template>
    <RegistrationFrame header-title="Grassroot Program">
<!-- Form Inputs-->
      <template #form>
        <UsableBaseInput v-model="entity_data.name" label="Startup Name" />
        <UsableBaseInput v-model="entity_data.founders" label="Founders" />
        <UsableBaseInput v-model="entity_data.email" label="Email" />
        <UsableBaseInput v-model="entity_data.phone_number" label="Phone Number" />
        <UsableBaseInput v-model="entity_data.website" label="Website" />
        <UsableBaseInput v-model="entity_data.industry" label="Industry | Sector" />
      </template>
    </RegistrationFrame>
</template>

<style scoped>

</style>