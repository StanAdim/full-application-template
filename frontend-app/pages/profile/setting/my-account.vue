<script setup lang="ts">
definePageMeta({
  title: 'Profile - Profile Name',
  layout: 'default',
  middleware:'auth',
})
useHead({
  title: 'My Account'
})
const globalData = useGlobalDataStore()
const activeName = ref('first')

const handleClick = (tab: TabsPaneContext, event: Event) => {
  // console.log(tab, event)
}
const init = () => {
  globalData.assignPageTitle('My Account')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
      <div class="">
        <el-tabs v-model="activeName" class="demo-tabs" @tab-click="handleClick">
          <el-tab-pane label="Profile Details" name="first">
            <div class="">
              <AuthProfileDetails />
            </div>
          </el-tab-pane>
          <el-tab-pane label="Account Details" name="second">
            <div class="">
              <AuthAccountDetails />
            </div>
          </el-tab-pane>

          <el-tab-pane label="Edit Account" name="fourth">
            <div class="">
              <AuthUpdateAccount />
            </div>
          </el-tab-pane>
          <el-tab-pane label="Change Password" name="fifth">
            <div class="">
              <AuthChangePassword />
            </div>
          </el-tab-pane>
          <el-tab-pane label="Edit Profile" name="third">
            <div class="">
              <AuthUpdateProfile />
            </div>
          </el-tab-pane>
        </el-tabs>
      </div>
</template>

<style scoped>

</style>