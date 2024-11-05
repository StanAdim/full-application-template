<script setup lang="ts">
import TheHero from "~/components/landing/TheHero.vue";
import TheCategories from "~/components/landing/TheCategories.vue";
import TheStats from "~/components/landing/TheStats.vue";
import TheSolutions from "~/components/landing/TheSolutions.vue";
import TheStakeholdersCall from "~/components/landing/TheStakeholdersCall.vue";
import CallForAction from "~/components/landing/CallForAction.vue";

definePageMeta({
  layout: 'landing',
  // middleware:'guest'
})
useHead({
  title: 'Landing',
})
const globalData = useGlobalDataStore()
</script>
<template>
  <div class="">
<!--    section 1-->
    <section class="h-[60vh] bg-fade-1">
       <TheHero />
    </section>
    <!--    section 2-->
    <section class="section">
      <TheCategories />
    </section>
    <!--    section 3-->
    <section class="section">
        <TheStats />
    </section>
    <!--    section 4-->
    <section class="section">
       <TheSolutions />
    </section>
    <!--    section 5-->
    <section class="section">
        <TheStakeholdersCall />
    </section>
    <!--    section 6-->
    <section class="section">
       <CallForAction />
    </section>
  </div>
</template>

<style scoped>
.section {
  height: 80vh;
}


</style>
