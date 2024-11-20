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
  current_password: '',
  new_password: '',
  password_confirmation: '',
  uid: auth.getLoggedUser?.uid,

})
const passwordIsConfirmed = computed(() => form_data.password_confirmation === form_data.new_password)

const handleLogin = async ()=> {
  // console.log(form_data)
  if (!passwordIsConfirmed.value){
    globalData.assignAlertMessage('Oops! Password mismatch.', 'warning')
  }else {
    await auth.changeUserPassword(form_data)
  }
}
</script>

<template>
  <div class=" ">
    <form @submit.prevent="handleLogin" class="max-w-md p-6  bg-fade-1 rounded-lg shadow-md">

      <UsableBaseInput :is-full="false" v-model="form_data.current_password" type="password"  placeholder="*************" label="Old Password" />
      <UsableBaseInput :is-full="false" v-model="form_data.new_password" type="password"  placeholder="*************" label="New Password" />
      <UsableBaseInput :is-full="false" v-model="form_data.password_confirmation" type="password"  placeholder="*************" label="Confirm Password" />

      <UsableLargeBtn type="small" color="blue" title="Change password"><TheBtnLoader /></UsableLargeBtn>

    </form>
  </div>
</template>

<style scoped>

</style>