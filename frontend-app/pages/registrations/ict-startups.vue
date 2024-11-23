<script setup lang="ts">

definePageMeta({
  title: 'Register',
      layout: 'guest',
})
const regStore = useRegistrationStore()
const genStore = useGeneralStore()
const femaleFounders = [{  label : 'Yes', value: 'Yes'}, {  label : 'No', value: 'No'} ]

const founderList = ref([{ founderName: '' , founderPhone: '+255..'}])
const entity_data = reactive({
    startup_name: '',
    founders: founderList.value,
    region_location: 1,
    email: '',
    phone_number: '+255',
    website: '',
    industry: 1,
    description: '',
    hasFemaleFounder: 'No',
    date_establishment: '',
    funding_stage: 1,
    team_size: 1,
})
const captureValue = () => {
  regStore.assignStartupData(entity_data)
}
const inputValues = computed(() => {
  return founderList.value.map(input => input.value)
})
const addInput = () => {
  founderList.value.push({ founderName: '' })
  console.log(inputValues)
}
const removeInput = (index) => {
  founderList.value.splice(index, 1)
  // Ensure at least one input remains
  if (founderList.value.length === 0) {
    founderList.value.push({ founderName: '' })
  }
}
const init = async () => {
  await Promise.all(
      [
        genStore.retrieveSectors(),
        genStore.retrieveFundingStages(),
        genStore.retrieveRegions(),
      ]
  )
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
    <UsableRegistrationFrame header-title="ICT Startup">
      <template #form>
         <!-- Form Section -->
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" placeholder="Startup Company Name" v-model="entity_data.startup_name" label="Startup Name" />
          <UsableBaseInput @change="captureValue" placeholder="Startup Company Email" v-model="entity_data.email" label=" Startup Email" />
        </div>
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" placeholder="+255" v-model="entity_data.phone_number" label="Startup Phone Number" />
          <UsableBaseInput @change="captureValue" placeholder="www.domain.com" v-model="entity_data.website" label="Website" />
        </div>
        <div class="form-groups">
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.region_location"  label="Region" :options="genStore.getRegions" />
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.industry"  label="Industry | Sector" :options="genStore.getSectors" />
        </div>
        <div class="form-groups">
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.funding_stage"  label="Funding Stage" :options="genStore.getFundingStage" />
          <UsableBaseInput @change="captureValue" placeholder="1"  type="number" v-model="entity_data.team_size"  label="Team Size"  />
        </div>
        <div class="form-groups">
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.hasFemaleFounder"  label="Has Female Founder" :options="femaleFounders" />
          <UsableBaseInput @change="captureValue" type="date" placeholder="..." v-model="entity_data.date_establishment" label="Date Of Establishment" />
        </div>
        <div class="title text-lg my-2">Founding Team
          <span @click="addInput"  class="text-xs font-bold hover:cursor-pointer text-sky-600 px-1 py-0.5 rounded-md">Add <i class="fa-solid fa-plus"></i></span>
        </div>
        <div class="flex gap-2" v-for="(input, index) in founderList" :key="index">
          <UsableBaseInput  @change="captureValue"  placeholder="Founder full name" v-model="input.founderName" label="Founder Full Name" />
          <UsableBaseInput  @change="captureValue"  placeholder="..." v-model="input.founderPhone" label="Founder Phone Number" />
          <button
              @click="removeInput(index)"
              class="mx-4 text-red-600 pt-2 text-lg"
          >
            <i class="fa-solid fa-trash-can"></i>
          </button>
        </div>
        <UsableBaseTextArea @change="captureValue" placeholder="Brief on vision and mission of the Startup toward problem solving and service delivering - Less than 200 words " v-model="entity_data.description"  label="Startup Brief Description"  />
      </template>
    </UsableRegistrationFrame>
</template>

<style scoped>

</style>