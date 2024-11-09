<script setup lang="ts">
import { ref } from 'vue'
const config = useRuntimeConfig()
const isSidebarOpen = ref(true)

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
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
        </div>

        <!-- Right section with profile -->
        <div class="flex items-center">
          <div class="flex items-center space-x-3 mx-4">
            <span class="text-sm hidden md:block">John Doe</span>
            <button class="rounded-full h-8 w-8 flex items-center justify-center bg-sky-100 hover:bg-sky-200 focus:outline-none">
              <i class="fa-solid fa-user"></i>
            </button>
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
            <slot />
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