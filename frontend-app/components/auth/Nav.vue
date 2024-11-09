<template>
  <nav
      class="order-first bg-blue-50 p-2 overflow-y-auto transition-all duration-300 ease-in-out"
      :class="{
          'w-32 md:min-w-48 md:max-w-64': props.isSidebarOpen,
          'w-0 md:w-0 opacity-0': !props.isSidebarOpen
        }"
  >
    <ul class="text-xs whitespace-nowrap">
      <li class="sidebar-link">
        <i class="fa-solid fa-user icon"></i>
        <nuxt-link to="/profile/dashboard">Dashboard</nuxt-link>
      </li>
      <!-- Projects with child links -->
      <li class="sidebar-link" @click="toggleMenu('projects')">
        <i class="fa-solid fa-diagram-project icon"></i>
        <span>Projects</span>
      </li>
      <ul v-if="activeMenu === 'projects'" class="pl-6">
        <li class="sidebar-sublink">
          <nuxt-link to="/profile/projects">My Projects</nuxt-link>
        </li>
        <li class="sidebar-sublink">
          <nuxt-link to="/profile/projects/create">New Project</nuxt-link>
        </li>

      </ul>
      <!-- Products with child links -->
      <li class="sidebar-link" @click="toggleMenu('products')">
        <i class="fa-regular fa-star icon"></i>
        <span>Products</span>
      </li>
      <ul v-if="activeMenu === 'products'" class="pl-6">
        <li class="sidebar-sublink">
          <nuxt-link to="/profile/products">My Products</nuxt-link>
        </li>
        <li class="sidebar-sublink">
          <nuxt-link to="/profile/products/create">New Products</nuxt-link>
        </li>
      </ul>
      <li class="sidebar-link">
        <i class="fa-solid fa-circle-info icon"></i>
        <nuxt-link to="/profile/1">Profile Info</nuxt-link>
      </li>
      <li class="sidebar-link">
        <i class="fa-solid fa-gear icon"></i>
        <nuxt-link to="/profile/1">Setting</nuxt-link>
      </li>
    </ul>
  </nav>
</template>

<script setup>
const props = defineProps({
  isSidebarOpen: {
    default: false,
    type: Boolean
  }
})
const activeMenu = ref('')
const toggleMenu = (menu) => {
  activeMenu.value = activeMenu.value === menu ? '' : menu
}
</script>

<style scoped>
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}

.sidebar-link {
  @apply block font-bold hover:bg-sky-200 py-2 px-2 mt-1 rounded bg-sky-100 cursor-pointer;
}

.sidebar-sublink {
  @apply block pl-4 py-1 text-sky-700 hover:text-sky-800 hover:bg-sky-100 rounded;
}

.sidebar-link .icon {
  @apply pr-2 text-sky-700 hover:text-sky-800;
}
</style>
