<script setup lang="ts">
const props = defineProps({
  data: {
    type: Object
  }
})

</script>

<template>
    <div class="">
      <h2 class="text-lg font-semibold text-gray-800">More on  ICT Innovation Hub </h2>
      <div class="mt-2">
        <p ><strong class="">Verification Status: </strong>
          <i v-if="props.data?.status" class="fa-solid  mx-2 fa-xl fa-circle-check text-green-500"></i>
          <i v-else class="fa-regular mx-2 fa-xl  fa-circle-xmark text-red-500"></i>
        </p>
        <p><strong>Total Members:</strong> {{ props.data?.totalMembers }}</p>
        <p><strong>Female Members:</strong> {{ props.data?.femaleNumber }}</p>
        <p><strong>Membership Option:</strong> {{ props.data?.membershipOption }}</p>
        <div><strong>Available Programs:</strong>
          <p v-for="(item, index) in props.data?.availablePrograms"
             :key="item">
            <span class=" ml-6 px-1 italic font-semibold text-sky-800">{{ index + 1 }} - {{item}}</span>
          </p>
        </div>
        <p><strong>Partnerships:</strong> {{ props.data?.partnerships }}</p>

      </div>
    </div>
</template>

<style scoped>

</style>