<script setup lang="ts">
import LargeBtn from "~/components/usable/large-btn.vue";

const props = defineProps({
  title: {
    default: 'Title',
    type: String
  },
  description: {
    default: 'Title',
    type: String
  },
  icon: {
    default: 'startup.png',
    type: String
  },
  style: {
    default: 'bg-blue-500 text-white',
    type: String
  }
})
const iconPath = computed(()=> `/images/icons/${props.icon}`)
</script>

<template>
  <div class="card" :class="props.style">
    <div class="card-inner">
      <div class="py-2 flex-1">
        <!-- Replace with appropriate icon -->
        <img class="h-[60px] w-[60px] " :src="iconPath" :alt="props.title">
      </div>
      <div class="">
        <h2 class="text-xl font-semibold">{{props.title}}</h2>
      </div>
    </div>
    <div class="">
      <p>{{props.description}}</p>
    </div>
    <div class="">
      <LargeBtn type="small" title="Read More"/>
    </div>
  </div>
</template>

<style scoped>
.card {
  @apply py-1 px-6 mx-2 shadow-2xl   rounded-md
}
.card-inner {
  @apply flex flex-col  space-x-3 mb-4
}
</style>