<script setup lang="ts">
import { ref } from 'vue';

// State to toggle mobile menu
const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>

<template>
  <div class="container mx-auto md:py-4 py-2">
    <div class="flex flex-col">
      <!-- Logos -->
<!--      <div class="my-4">-->
<!--        <div class="flex flex-row md:justify-center justify-between mx-4">-->
<!--          <div class="logo">-->
<!--            <img src="/images/nembo_ya_taifa-opt.png" alt="logo dark" />-->
<!--          </div>-->
<!--          <div class="logo">-->
<!--            <img src="/images/ictc-logo-white-opt.png" alt="logo dark" />-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->

      <!-- Navigation -->
      <div class="nav flex flex-row justify-between items-center">
        <div>
          <!-- Mobile menu button -->
          <button
              class="border-black mx-2 md:hidden"
              @click="toggleMobileMenu"
          >
            <span v-if="!isMobileMenuOpen">☰</span>
            <span v-else>✖</span>
          </button>

          <!-- Desktop menu -->
          <ul class="hidden md:flex flex-row flex-wrap gap-4">
            <li class="active nav-link">
              <nuxt-link to="/">Home</nuxt-link>
            </li>
            <li class="nav-link">
              <nuxt-link to="/profiles/">Approved Registrations</nuxt-link>
            </li>
          </ul>
        </div>

        <div class="logo">
          <img src="/images/ictc-logo-white-opt.png" alt="logo dark" />
        </div>

        <!-- Accounts -->
        <div class="flex flex-row flex-wrap gap-2 mx-2">
          <div class="login">
            <nuxt-link to="/login">
              <button class="btn border-black">Login</button>
            </nuxt-link>
          </div>
          <div class="register">
            <nuxt-link to="/register">
              <button class="btn appBg text-white border-sky-500">
                Register
              </button>
            </nuxt-link>
          </div>
        </div>
      </div>

      <!-- Mobile menu dropdown -->
      <div
          v-if="isMobileMenuOpen"
          class="mobile-menu bg-sky-100 p-4 mx-2 rounded-lg mt-2 md:hidden"
      >
        <ul class="flex flex-col gap-4 text-sm">
          <li class="active nav-link">
            <nuxt-link to="/" @click="toggleMobileMenu">Home</nuxt-link>
          </li>
          <li class="nav-link">
            <nuxt-link to="/profiles/" @click="toggleMobileMenu">
              Approved Registrations
            </nuxt-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<style scoped>
.btn {
  @apply border-2 px-8 py-1 font-bold my-1 rounded-full;
}
.router-link-active {
  @apply text-sky-500 font-extrabold;
}
.nav-link {
  @apply text-lg hover:text-sky-700 font-bold;
}
.logo img {
  @apply md:h-[100px] w-auto h-[80px];
}
.mobile-menu {
  @apply shadow-lg;
}
</style>
