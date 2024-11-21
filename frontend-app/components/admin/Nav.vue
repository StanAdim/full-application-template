
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
  {title: 'Profiles' ,path: '#', icon: 'fa-solid fa-circle-info', childLinks:[
      {title: 'ICT Startups', path: '/admin/profiles/startups', icon: 'fa-solid fa-code'},
      {title: 'Innovation Hubs', path: '/admin/profiles/hubs', icon: 'fa-solid fa-landmark'},
      {title: 'Digital Accelerators', path: '/admin/profiles/accelerators', icon: 'fa-solid fa-chart-simple'},
      {title: 'Grassroot Programs', path: '/admin/profiles/grassroots', icon: 'fa-solid fa-seedling'},
    ]},
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
      <li class="" v-for="link in link_options" @click="toggleMenu(link.title)">
        <nuxt-link :to="link.path" class="sidebar-link"> <i class="icon" :class="`${link.icon}`"></i>{{ link.title }}</nuxt-link>
        <ul v-if="activeMenu === link.title" class="pl-4 mt-1">
          <li class="py-0.5" v-for="sub_item in link.childLinks" :ref="sub_item.title">
            <nuxt-link  class="sidebar-sublink" :to="sub_item.path"> <i class="icon" :class="`${sub_item.icon}`"></i> {{ sub_item.title }}</nuxt-link>
          </li>
        </ul>
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
  @apply block bg-sky-800 pl-1 py-1 text-white hover:text-sky-800 hover:bg-sky-100 rounded;
}

.sidebar-link .icon {
  @apply pr-2 text-sky-700 hover:text-sky-800;
}
</style>
