<script setup lang="ts">
definePageMeta({
  layout: 'guest',
  middleware: 'guest'
})
useHead({
  title: 'Login',
})
const globalData = useGlobalDataStore()
const form_data = reactive({
  email: '',
  password: '',
  rememberMe: ''
})
const handleLogin = ()=> {
  console.log(form_data)
}
const IsNotFilled = computed(() => !(form_data.email.length > 0 && form_data.password.length > 0) )
</script>

<template>
  <div class="md:mt-[10vh] ">
    <form @submit.prevent="handleLogin" class="max-w-md mx-auto p-6  bg-fade-1 rounded-lg shadow-md">
      <h2 class="text-2xl appColor font-bold text-center mb-6">Login to Your Account</h2>
      <UsableBaseInput v-model="form_data.email" type="email" label="Email Address" placeholder="Enter your email" />
      <UsableBaseInput v-model="form_data.password" type="password" label="Password" placeholder="Enter your password" />

      <div class="flex justify-between items-center mb-4">
        <label class="flex items-center text-sm text-gray-600">
          <input type="checkbox" v-model="form_data.rememberMe" class="mr-2" />
          Remember Me
        </label>
        <nuxt-link to="/forgot-password" class="text-sm text-blue-500 hover:underline">Forgot Password?</nuxt-link>
      </div>
      <UsableBaseButton :disabled="IsNotFilled" type="submit" color="blue">Login</UsableBaseButton>
    </form>
  </div>
</template>

<style scoped>

</style>