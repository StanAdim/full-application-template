<template>
  <div class="border-2 border-sky-300 bg-white font-semibold py-4 md:py-6 px-4 rounded-md hover:bg-green-50 transition">
    <a :href="props.to" target="_blank">
      <button class=" text-green-600 ">
        {{ label }}
      </button>
    </a>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  label: { type: String, required: true },
  to: { type: String, required: true },
});
</script>

<style scoped>
/* Add any additional styles if needed */
</style>
