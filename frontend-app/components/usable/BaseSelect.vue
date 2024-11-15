<template>
  <div class="mb-4">
    <label v-if="label" class="block text-gray-600 text-sm font-semibold mb-1">{{ label }}</label>
    <select
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :class="{'md:w-72 w-full':props.isFull, 'w-full': !props.isFull}"
        class=" border border-gray-300 rounded-lg px-4 py-4 focus:outline-none focus:border-blue-500">
      <option selected value="0" disabled>Select {{props.label}}</option>
      <option v-for="option in options" :key="option.value" :value="option.value">{{ option.label }}</option>
    </select>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  label: { type: String, default: 'Select' },
  isFull: { type: String, default: true },
  modelValue: { type: [String, Number], required: true },
  options: { type: Array, default: () => [] },
});
const emit = defineEmits(['update:modelValue']);
</script>

<style scoped>
/* Scoped styles if needed */
</style>