<script setup lang="ts">
const props = defineProps({
  title: {
    type: String,
    default: 'Submit'
  },

})
</script>

<template>
    <button class="border-2 border-sky-500 appBg  font-bold text-white px-10 py-2 my-4 rounded-full" >{{props.title}}</button>
</template>

<style scoped>

</style>