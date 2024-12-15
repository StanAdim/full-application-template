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
      {title: 'Dashboard', path: '/profile/dashboard', icon: 'fa-solid fa-house', childLink: []},
      {
        title: 'ICT Products', path: '/profile/products', icon: 'fa-regular fa-star', childLink: [
          {title: 'All Products', path: '/profile/products', icon: 'fa-solid fa-list'},
          {title: 'New Product', path: '/profile/products/create', icon: 'fa-solid fa-plus'},
        ]
      },
      {
        title: 'ICT Projects', path: '/profile/projects', icon: 'fa-solid fa-diagram-project', childLink: [
          {title: 'All Projects', path: '/profile/projects', icon: 'fa-solid fa-list'},
          {title: 'New Project', path: '/profile/projects/create', icon: 'fa-solid fa-plus'},
        ]
      },
      {title: 'Documents', path: '/profile/documents', icon: 'fa-regular fa-folder', childLink: []},
      {title: 'Profile Info', path: '/profile/setting/my-account', icon: 'fa-solid fa-circle-info', childLink: []},

    ]
</script>
<template>
  <nav
      class="order-first bg-blue-50 p-2 overflow-y-auto transition-all duration-300 ease-in-out"
      :class="{
          'w-32 md:min-w-48 md:max-w-64': props.isSidebarOpen,
          'w-0 md:w-0 opacity-0': !props.isSidebarOpen
        }"
  >
    <ul class="text-xs whitespace-nowrap">
      <li v-for="item in link_options" :ref="item" @click="toggleMenu(item.title)">
        <nuxt-link class="sidebar-link"
                   :to="item.path"> <i class="icon" :class="`${item.icon}`"></i>
          <span>{{ item.title }}</span></nuxt-link>
        <ul v-if="activeMenu === item.title" class="pl-6">
          <li class="py-0.5" v-for="sub_item in item.childLink" :ref="sub_item.title">
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

.icon {
  @apply px-2
}

.sidebar-link {
  @apply block font-bold hover:bg-sky-200 py-2 px-2 mt-2 rounded bg-sky-100 cursor-pointer;
}

.sidebar-sublink {
  @apply block pl-2 py-1.5 text-sky-700 hover:text-sky-800 hover:bg-sky-100 rounded;
}

.sidebar-link .icon {
  @apply pr-2 text-sky-700 hover:text-sky-800;
}
.router-link-active {
  background: linear-gradient(45deg, #0ba9f9, #0996dd);
  color: white;
  border-radius: 10px;
  &:hover {
    background: linear-gradient(45deg, #0ba9f9, #0996dd) !important;
    color: white !important;
  }
}
</style>
