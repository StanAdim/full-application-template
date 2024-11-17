<script setup lang="ts">
import { ClickOutside as vClickOutside } from 'element-plus'

const popoverRef = ref()
const onClickOutside = () => {
  unref(popoverRef).popperRef?.delayHide?.()
}
const config = useRuntimeConfig()
const gData = useGlobalDataStore()
const auth = useAuthStore()
const isSidebarOpen = ref(true)

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}
const logout = async  ()=> {
  await auth.logout()
}
</script>

<template>
  <div>
    <div class="min-h-screen h-screen flex flex-col">
      <header class="bg-gray-50 border-b border-sky-300 p-2 flex items-center justify-between">
        <!-- Left section with menu toggle and title -->
        <div class="flex items-center">
          <button
              @click="toggleSidebar"
              class="p-2 rounded-md hover:bg-sky-100 focus:outline-none"
          >
            <i v-if="isSidebarOpen" class="fa-solid fa-bars-staggered"></i>
            <i v-else class="fa-solid fa-angles-left"></i>
          </button>
          <span class="ml-4 font-extrabold ">{{ config.public.appName}}</span>
          <sub class="mx-2 text-xs text-sky-800 mt-3">{{auth.getProfileCategoryName}}</sub>
        </div>
        <!-- Right section with profile -->
        <div class="flex items-center">
          <div class="flex items-center space-x-3 mx-4">
                <div class="text-black/80">{{ auth.getLoggedUser?.name }} </div>
            <el-dropdown placement="bottom-start">
              <div class="">
                <button class="rounded-full h-8 w-8 flex items-center justify-center bg-sky-100 hover:bg-sky-200 focus:outline-none"><i class="fa-solid fa-user"></i></button>
              </div>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item>
                    <nuxt-link to="/profile/setting/my-account">
                      <div class="hover:bg-sky-100 p-0.5 my-0.5 rounded-md px-1"><i class="pr-2 fa-solid fa-user-gear"></i>My Account</div>
                    </nuxt-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <div @click.prevent="logout" class="hover:bg-sky-100 hover:text-red-500 p-0.5 my-0.5 rounded-md px-1">
                      <i class="pr-2 fa-solid fa-arrow-left"></i>Logout <UsableTheBtnLoader /></div>
                  </el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>

          </div>
        </div>
      </header>

      <!-- main container -->
      <div class="flex-1 flex flex-row overflow-y-hidden">
        <main
            class="flex-1 bg-sky-50 border-l border-r border-sky-300 text-xs p-2 overflow-y-auto"
            :class="{ 'ml-0': !isSidebarOpen }"
        >
          <div class="leading-10">
            <!-- Your Lorem Ipsum content -->
            <div class="bg-white rounded-lg shadow p-6">
              <div class="flex flex-row gap-4">
                <div class="text-xl text-sky-600 font-semibold mb-4">{{ gData.getPageTitle }}</div>
                <div class=""><UsableContentLoader  color=""/></div>
              </div>
              <hr class="bg-sky-600 py-[1px] rounded-md">
              <div class="text-gray-600">
                <slot />
              </div>
            </div>
          </div>
        </main>
        <!-- Modified sidebar nav -->
        <AuthNav :is-sidebar-open="isSidebarOpen" />
      </div>
    </div>
      <footer class="bg-sky-50 border-t border-sky-300 p-2 text-center">{{config.public.instName}} @ 2024</footer>
  </div>
</template>

<style scoped>

</style>