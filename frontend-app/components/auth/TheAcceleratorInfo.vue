<script setup lang="ts">
const auth = useAuthStore()

</script>

<template>
    <div class="">
      <h2 class="text-lg font-semibold text-gray-800">More on  Digital Accelerator </h2>
      <div class="mt-2">
        <p ><strong class="">Verification Status: </strong>
          <i v-if="auth.getUserProfileable?.status" class="fa-solid  mx-2 fa-xl fa-circle-check text-green-500"></i>
          <i v-else class="fa-regular mx-2 fa-xl  fa-circle-xmark text-red-500"></i>
        </p>
        <div><strong>Program Focus Area: </strong>
          <p v-for="(item, index) in auth.getUserProfileable?.focusArea"
             :key="item">
            <span class=" ml-6 px-1 italic font-semibold text-sky-800">{{ index + 1 }} - {{item}}</span>
          </p>
        </div>
      </div>
    </div>
</template>

<style scoped>

</style>