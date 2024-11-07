<template>
  <button
      :type="type"
      :class="[
      'w-full py-2 rounded-md font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors',
      buttonStyles,
    ]"
      :disabled="disabled"
      @click="onClick"
  >
    <slot />
  </button>
</template>

<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
  type: { type: String, default: 'button' },
  color: { type: String, default: 'blue' },
  disabled: { type: Boolean, default: false },
});

const buttonStyles = computed(() => {
  const baseStyles = {
    blue: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-500',
    green: 'bg-green-500 text-white hover:bg-green-600 focus:ring-green-500',
    red: 'bg-red-500 text-white hover:bg-red-600 focus:ring-red-500',
    gray: 'bg-gray-500 text-white hover:bg-gray-600 focus:ring-gray-500',
  };
  return props.disabled ? 'bg-gray-400 text-white cursor-not-allowed' : baseStyles[props.color];
});

const onClick = (event) => {
  if (props.disabled) {
    event.preventDefault();
  }
};
</script>
