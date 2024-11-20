<script setup lang="ts">
import TheBtnLoader from "~/components/usable/TheBtnLoader.vue";

definePageMeta({
  layout: 'guest',
  middleware: 'guest'
})
useHead({
  title: 'Login',
})
const globalData = useGlobalDataStore()
const auth = useAuthStore()
const form_data = reactive({
  first_name: auth.getLoggedUser?.firstName,
  middle_name: auth.getLoggedUser?.middleName,
  last_name: auth.getLoggedUser?.lastName,
  phone_number: auth.getLoggedUser?.phone,
  uid: auth.getLoggedUser?.uid,
})
const handleLogin = async ()=> {
  // console.log(form_data)
  await auth.updateUserAccount(form_data)
}
</script>

<template>
  <div class=" ">
    <form @submit.prevent="handleLogin" class="max-w-md p-6  bg-fade-1 rounded-lg shadow-md">

      <label  class="block text-gray-600 text-sm font-semibold my-3">Account Email : <span class="text-sky-500">{{ auth.getLoggedUser?.email }}</span></label>
      <UsableBaseInput :is-full="false" v-model="form_data.first_name"  placeholder="first name" label="First Name" />
      <UsableBaseInput :is-full="false" v-model="form_data.middle_name"  placeholder="middle name" label="Middle Name" />
      <UsableBaseInput :is-full="false" v-model="form_data.last_name"  placeholder="last name" label="Last Name" />
      <UsableBaseInput :is-full="false" v-model="form_data.phone_number" label="Phone Number" placeholder="+255.." />
      <UsableLargeBtn  type="small" color="blue" title="Update"><TheBtnLoader /></UsableLargeBtn>
    </form>
  </div>
</template>

<style scoped>

</style>