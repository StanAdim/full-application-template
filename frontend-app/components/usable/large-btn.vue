<script setup lang="ts">
const props = defineProps({
  title: {
    type: String,
    default: 'Submit'
  },
  type: {
    type: String,
    default: 'large'
  },

})
const isLarge = computed(()=> props.type === "large")
</script>

<template>
    <button
        class="border-2 border-sky-500 appBg  font-bold text-white  my-4 rounded-full"
        :class="{'px-10 py-2': isLarge, 'px-6 py-0': !isLarge}"
    >{{props.title}}</button>
</template>

<style scoped>

</style>