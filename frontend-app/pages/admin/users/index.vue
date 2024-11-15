<script setup lang="ts">
definePageMeta({
  title: 'Admin-Users',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const userStore = useUserStore()
const init = async () => {
  globalData.assignPageTitle('Users')
  await  userStore.retrieveUserList()
  console.log(userStore.getUserList)
}
const handleClick = () => {
  console.log('click')
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    Admin - Users
    <div class="rounded-md ">
      <el-table border class-name="border-2 rounded-md border-emerald-600" :data="userStore.getUserList" style="width: 100%">
        <el-table-column type="index" label="SN" width="100" />
        <el-table-column prop="name" label="Name" width="auto" />
        <el-table-column prop="email" label="Email" width="auto" />
        <el-table-column prop="phone" label="Phone" width="auto" />
        <el-table-column prop="rank" label="Rank" width="auto" />
        <el-table-column  prop="registrationDate" label="Reg Date" width="auto" />
        <el-table-column  prop="last_login" label="Last Login " width="auto" />
<!--        <el-table-column prop="Email Verification" label="isVerified" width="120" />-->
        <el-table-column fixed="right" label="Operations" min-width="120">
          <template #default>
            <el-button link type="primary" size="small" @click="handleClick">
              Detail
            </el-button>
            <el-button link type="primary" size="small">Edit</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>

<style scoped></style>
