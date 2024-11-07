<template>
  <div class="flex items-center flex-col gap-4">
    <div :class="['text-4xl font-bold', `text-${color}`]">{{ number }}</div>
    <div class="flex flex-col">
      <span class="text-lg font-semibold text-gray-700">{{ label }}</span>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  color: { type: String, required: true },
  number: { type: String, required: true },
  label: { type: String, required: true },
});
</script>
