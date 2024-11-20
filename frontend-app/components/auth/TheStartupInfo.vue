<script setup lang="ts">
const auth = useAuthStore()

</script>

<template>
    <div class="">
      <h2 class="text-lg font-semibold text-gray-800">More on  ICT Startup </h2>
      <div class="mt-2">
        <p ><strong class="">Verification Status: </strong>
          <i v-if="auth.getUserProfileable?.status" class="fa-solid  mx-2 fa-xl fa-circle-check text-green-500"></i>
          <i v-else class="fa-regular mx-2 fa-xl  fa-circle-xmark text-red-500"></i>
        </p>
        <p><strong>Team Size:</strong> {{ auth.getUserProfileable?.teamSize }}</p>
        <p><strong>Industry|Sector:</strong> {{ auth.getUserProfileable?.industry }}</p>
        <p><strong>Funding Stage:</strong> {{ auth.getUserProfileable?.fundingStage }}</p>
        <p><strong>Website:</strong> {{ auth.getUserProfileable?.website }}</p>
        <div><strong>Founders:</strong>
          <p v-for="item in auth.getUserProfileable?.founders" class="ml-6"
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