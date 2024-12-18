<script setup lang="ts">
definePageMeta({
  title: 'Admin - ICT Startups',
  layout: 'admin',
  middleware:['auth', 'admin-role-checker'],
})
const globalData = useGlobalDataStore()
const adminStore = useAdminDataStore()
const documentStore = useDocumentStore()


const init = async () => {
  globalData.assignPageTitle('Settings')
  await  documentStore.retrieveDocumentTypes()
}
const activeName = ref('first')
const handleClick = (tab: TabsPaneContext, event: Event) => {
  // console.log(tab, event)
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
  <div class="">
    <div class="title">Admin - Settings </div>
    <div class="">
      <el-tabs v-model="activeName" class="demo-tabs" @tab-click="handleClick">
        <el-tab-pane label="User" name="first">User</el-tab-pane>
        <el-tab-pane label="Config" name="second">Config</el-tab-pane>
        <el-tab-pane label="Roles" name="third">Roles</el-tab-pane>
        <el-tab-pane label="Document Types" name="fourth">
            <AdminDocumentTypes :data="documentStore.getDocTypes" />
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>
</template>

<style scoped></style>
