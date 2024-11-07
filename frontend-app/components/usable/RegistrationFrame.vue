<script setup lang="ts">
const props = defineProps({
  headerTitle : {
    default: "Registration Frame",
    type: String
  }
})
</script>

<template>
  <div class="">
    <div class="flex flex-col items-center justify-center p-6">
      <!-- Header Section -->
      <div class="text-center mb-6">
        <p class="appColor font font-bold text-xl md:text-3xl">{{ props.headerTitle }} Registration</p>
      </div>

      <slot name="form" />

    </div>
  </div>
</template>

<style scoped>

</style>