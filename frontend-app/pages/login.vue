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
  email: '',
  password: '',
  rememberMe: ''
})
const handleLogin = async ()=> {
  // console.log(form_data)
  await auth.login(form_data)

}
const IsNotFilled = computed(() => !(form_data.email.length > 0 && form_data.password.length > 0) )
</script>

<template>
  <div class="md:py-[8vh] bg-fade-1">
    <div class="flex flex-row justify-center items-center w-full my-2">
        <img src="/images/icons/secure-folder.png" class="py-2 w-20 h-20 md:w-32 md:h-32" alt="">
        <img src="/images/icons/hand.png" class="py-2 w-20 h-20 md:w-32 md:h-32" alt="">
        <img src="/images/icons/vr.png" class="py-2 w-20 h-20 md:w-32 md:h-32" alt="">
    </div>
    <form @submit.prevent="handleLogin" class="max-w-md mx-auto p-6  bg-fade-1 rounded-lg shadow-md">
      <h2 class="text-2xl appColor font-bold text-center mb-6">Login to Your Account</h2>
      <UsableBaseInput :is-full="false" v-model="form_data.email" type="email" label="Email Address" placeholder="Enter your email" />
      <UsableBaseInput :is-full="false" v-model="form_data.password" type="password" label="Password" placeholder="Enter your password" />

      <div class="flex justify-between items-center mb-4">
        <label class="flex items-center text-sm text-gray-600">
          <input type="checkbox" v-model="form_data.rememberMe" class="mr-2" />
          Remember Me
        </label>
        <nuxt-link to="/forgot-password" class="text-sm text-blue-500 hover:underline">Forgot Password?</nuxt-link>
      </div>
      <UsableBaseButton :disabled="IsNotFilled" type="submit" color="blue">Login <TheBtnLoader /></UsableBaseButton>
      <div class="mt-2 text-sm">
        <p >Not registered?, <nuxt-link class="appColor hover:text-sky-700 hover:cursor-pointer" to="/register">Create  Account</nuxt-link></p>
      </div>
    </form>
  </div>
</template>

<style scoped>

</style>