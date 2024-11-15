
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
const link_options = [
  {title: 'Dashboard' ,path: '/admin/dashboard', icon: 'fa-solid fa-house'},
  {title: 'Profiles' ,path: '/admin/profiles', icon: 'fa-solid fa-circle-info'},
  {title: 'Projects' ,path: '/admin/projects', icon: 'fa-solid fa-diagram-project'},
  {title: 'Products' ,path: '/admin/products', icon: 'fa-regular fa-star'},
  {title: 'Programmes' ,path: '/admin/programmes', icon: 'fa-solid fa-circle-half-stroke'},
  {title: 'Users' ,path: '/admin/users', icon: 'fa-solid fa-users'},
  {title: 'Documents' ,path: '/admin/documents', icon: 'fa-solid fa-file-contract'},
  {title: 'Settings' ,path: '/admin/settings', icon: 'fa-solid fa-gear'},
  {title: 'Configurations' ,path: '/admin/dashboard', icon: 'fa-solid fa-toolbox'},
]
</script>
<template>
  <nav
      class="order-first bg-sky-700 p-2 overflow-y-auto transition-all duration-300 ease-in-out"
      :class="{
          'w-32 md:min-w-48 md:max-w-64': props.isSidebarOpen,
          'w-0 md:w-0 opacity-0': !props.isSidebarOpen
        }"
  >
    <ul class="text-xs whitespace-nowrap">
      <li class="" v-for="link in link_options" >
        <nuxt-link :to="link.path" class="sidebar-link"> <i class="icon" :class="`${link.icon}`"></i>{{ link.title }}</nuxt-link>
      </li>
    </ul>
  </nav>
</template>


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
