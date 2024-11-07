<script setup lang="ts">
definePageMeta({
  layout: 'guest',
  middleware: 'guest'
})
useHead({
  title: 'Forgot Password',
})
const globalData = useGlobalDataStore()
const form_data = reactive({
  email: '',
})
const handleLogin = ()=> {
  console.log(form_data)
}
const IsNotFilled = computed(() => !(form_data.email.length > 0) )

</script>

<template>
  <div class="md:mt-[10vh] ">
    <form @submit.prevent="handleLogin" class="max-w-md mx-auto p-6  bg-fade-1 rounded-lg shadow-md">
      <h2 class="text-2xl appColor font-bold text-center mb-6">Request Password Reset</h2>
      <UsableBaseInput v-model="form_data.email" type="email" label="Email Address" placeholder="Enter your email" />
      <div class="flex justify-end items-center mb-4">
        <nuxt-link to="/login" class="text-sm text-blue-500 hover:underline">Go Back</nuxt-link>
      </div>
      <UsableBaseButton :disabled="IsNotFilled" type="submit" color="blue">Submit</UsableBaseButton>

    </form>
  </div>
</template>

<style scoped>

</style>