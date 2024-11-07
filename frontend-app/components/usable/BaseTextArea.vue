<template>
  <div class="mb-4">
    <label v-if="label" class="block text-gray-600 text-sm font-semibold mb-1">{{ label }}</label>
    <textarea
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
        rows="3">
    </textarea>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  label: { type: String, default: 'Text Area' },
  placeholder: { type: String, default: '' },
  modelValue: { type: [String, Number], required: true },
});
const emit = defineEmits(['update:modelValue']);
</script>

<style scoped>
/* Scoped styles if needed */
</style>