<script setup lang="ts">
const props = defineProps({
  title: {
    type: String,
    default: 'title'
  },
  count: {
    type: String,
    default: '...'
  },
  path: {
    type: String,
    default: 'title'
  },
})
</script>

<template>
  <div class="flex flex-col border-b border-sky-100 p-6 text-center sm:border-0 sm:border-r">

    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-sky-500">
      {{ props.title }}
    </dt>
    <dd class="order-1 text-5xl font-extrabold text-sky-700">{{ props.count }}+</dd>
    <NuxtLink :to="props.path">
      <p class="bg-sky-500 rounded-lg text-white py-0.5 cursor-pointer my-4">View</p>
    </NuxtLink>
  </div>
</template>

<style scoped>

</style>