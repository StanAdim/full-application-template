<template>
  <button class="border-2 border-sky-300 text-green-600 bg-white font-semibold py-4 md:py-6 px-4 rounded-md hover:bg-green-50 transition">
    {{ label }}
  </button>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  label: { type: String, required: true },
});
</script>

<style scoped>
/* Add any additional styles if needed */
</style>
