<script setup lang="ts">
const props = defineProps({
  title : {
    default: 'Title',
    type: String
  },
  size : {
    default: 'Title',
    type: [Number, String]
  },
  path : {
    default: '/',
    type: String
  },
})
</script>

<template>
  <div class="flex-1 bg-sky-100 border border-sky-200 rounded-xl p-6 animate-fade-in">
    <h2 class="text-xl md:text-3xl text-sky-900">
      {{ props.title }} <br><strong>{{ props.size }}</strong>
    </h2>
    <nuxt-link :to="props.path" class="inline-block mt-8 px-8 py-2 rounded-full text-xl font-bold text-white bg-sky-800 hover:bg-sky-900 transition-transform duration-300 hover:scale-105">
      <i class="fa-solid fa-arrow-right-long"></i>
    </nuxt-link>
  </div>
</template>

<style scoped>

</style>