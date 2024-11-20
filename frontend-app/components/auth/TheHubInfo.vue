<script setup lang="ts">
const auth = useAuthStore()

</script>

<template>
    <div class="">
      <h2 class="text-lg font-semibold text-gray-800">More on  ICT Innovation Hub </h2>
      <div class="mt-2">
        <p ><strong class="">Verification Status: </strong>
          <i v-if="auth.getUserProfileable?.status" class="fa-solid  mx-2 fa-xl fa-circle-check text-green-500"></i>
          <i v-else class="fa-regular mx-2 fa-xl  fa-circle-xmark text-red-500"></i>
        </p>
        <p><strong>Total Members:</strong> {{ auth.getUserProfileable?.totalMembers }}</p>
        <p><strong>Female Members:</strong> {{ auth.getUserProfileable?.femaleNumber }}</p>
        <p><strong>Membership Option:</strong> {{ auth.getUserProfileable?.membershipOption }}</p>
        <div><strong>Available Programs:</strong>
          <p v-for="(item, index) in auth.getUserProfileable?.availablePrograms"
             :key="item">
            <span class=" ml-6 px-1 italic font-semibold text-sky-800">{{ index + 1 }} - {{item}}</span>
          </p>
        </div>
        <p><strong>Partnerships:</strong> {{ auth.getUserProfileable?.partnerships }}</p>

      </div>
    </div>
</template>

<style scoped>

</style>