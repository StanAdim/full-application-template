<script setup lang="ts">

definePageMeta({
  title: 'Register',
      layout: 'guest',
})
const regStore = useRegistrationStore()
const regions = [{  label : 'Arusha', value: '1'}, ]
const femaleFounders = [{  label : 'Yes', value: '1'}, {  label : 'No', value: '0'} ]
const sectors = [
  {label: 'Artificial Intelligence', value : '1'},
  {label: 'WebDev', value : '2'},
]
const founderList = ref([{ founderName: '' }])
const entity_data = reactive({
  name: '',
  founders: founderList.value,
  region: '',
  email: '',
  phone_number: '',
  website: '',
  industry: ''
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
</script>

<template>
    <UsableRegistrationFrame header-title="ICT Startup">
      <template #form>
         <!-- Form Section -->
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.name" label="Startup Name" />
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.email" label="Email" />
        </div>
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.phone_number" label="Phone Number" />
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.website" label="Website" />
        </div>
        <div class="form-groups">
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.region"  label="Region" :options="regions" />
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.industry"  label="Industry | Sector" :options="sectors" />
        </div>
        <div class="title text-lg my-2">Founding Team
          <span @click="addInput"  class="text-xs font-bold hover:cursor-pointer text-sky-600 px-1 py-0.5 rounded-md">Add <i class="fa-solid fa-plus"></i></span>
        </div>
        <div class="flex gap-2" v-for="(input, index) in founderList" :key="index">
          <UsableBaseInput  @change="captureValue"  placeholder="..." v-model="input.founderName" label="Founder Name" />
          <button
              @click="removeInput(index)"
              class="mx-4 text-red-600 pt-2 text-lg"
          >
            <i class="fa-solid fa-trash-can"></i>
          </button>
        </div>
        <div class="form-groups">
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.hasFemaleFounder"  label="Has Female Founder" :options="femaleFounders" />
          <UsableBaseInput @change="captureValue" type="date" placeholder="..." v-model="entity_data.dateOfEstablishment" label="Date Of Establishment" />
        </div>
        <UsableBaseTextArea @change="captureValue" placeholder="..." v-model="entity_data.brief"  label="Startup Brief Description"  />
      </template>
    </UsableRegistrationFrame>
</template>

<style scoped>
.form-groups {
  @apply flex md:flex-row flex-col justify-between my-0 py-0
}
</style>