<script setup lang="ts">
const props = defineProps({
  description: {
    type: String,
    default: ''
  },
  title: {
    type: String,
    default: ''
  },
})
</script>

<template>
  <div class="w-full mb-10 sm:mb-0">
    <div class="relative h-full ml-0 mr-0 sm:mr-10">
      <span class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-sky-500 rounded-lg"></span>
      <div class="relative h-full p-5 bg-white border-2 border-sky-500 rounded-lg">
        <div class="flex items-center -mt-1">
          <h3 class="my-2 ml-3 text-lg font-bold text-gray-800">{{ props.title }}</h3>
        </div>
        <p class="mt-3 mb-1 text-xs font-medium text-sky-500 uppercase">------------</p>
        <p class="mb-2 text-gray-600">{{ props.description }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>