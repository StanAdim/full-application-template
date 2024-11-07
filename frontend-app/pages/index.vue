<script setup lang="ts">


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
       <LandingTheHero />
    </section>
    <!--    section 2-->
    <section class="section">
      <LandingTheCategories />
    </section>
    <!--    section 3-->
    <section class="section">
        <LandingTheStats />
    </section>
    <!--    section 4-->
    <section class="section">
       <LandingTheSolutions />
    </section>
    <!--    section 5-->
    <section class="section">
        <LandingTheStakeholdersCall />
    </section>
    <!--    section 6-->
    <section class="section">
       <LandingCallForAction />
    </section>
  </div>
</template>

<style scoped>
.section {
 @apply pt-8
}


</style>
