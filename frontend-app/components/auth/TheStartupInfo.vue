<script setup lang="ts">
const props = defineProps({
  data: {
    type: Object
  }
})
</script>

<template>
    <div class="">
      <h2 class="text-lg font-semibold text-gray-800">More on  ICT Startup </h2>
      <div class="mt-2">
        <p ><strong class="">Verification Status: </strong>
          <i v-if="props.data?.status" class="fa-solid  mx-2 fa-xl fa-circle-check text-green-500"></i>
          <i v-else class="fa-regular mx-2 fa-xl  fa-circle-xmark text-red-500"></i>
        </p>
        <p><strong>Team Size:</strong> {{ props.data?.teamSize }}</p>
        <p><strong>Industry|Sector:</strong> {{ props.data?.industry }}</p>
        <p><strong>Funding Stage:</strong> {{ props.data?.fundingStage }}</p>
        <p><strong>Website:</strong> {{ props.data?.website }}</p>
        <div><strong>Founders:</strong>
          <p v-for="item in props.data?.founders" class="ml-6"
             :key="item?.founderName">
            <span class="px-1 italic font-semibold text-sky-800">{{item?.founderName}}</span> -
            <span class="px-1 italic text-sky-700">{{item?.founderPhone}}</span>
          </p>
        </div>
      </div>
    </div>
</template>

<style scoped>

</style>