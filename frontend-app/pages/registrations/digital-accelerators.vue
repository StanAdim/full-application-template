<script setup lang="ts">
import RegistrationFrame from "~/components/usable/RegistrationFrame.vue";

definePageMeta({
  title: 'Digital Accelerator Registration',
      layout: 'guest',
})
const globalData = useGlobalDataStore()
const regStore = useRegistrationStore()

const regionsOptions = [{  label : 'Arusha', value: '1'}, {  label : 'Mwanza', value: '2'}, ]
const focus_area_options = [
  {  label : 'AI', value: 'AI'},
  {  label : 'Fin Tech', value: 'Fin Tech'},
  {  label : 'EduTech', value: 'EduTech'},
  {  label : 'Health Tech', value: 'Health Tech'},
]
const entity_data = reactive({
  accelerator_name: '',
  focus_area: '',
  brief_description: '',
  region_location: '',
  date_establishment: '',
  phone_number: '',
  email: '',
})
const captureValue = () => {
  regStore.assignAcceleratorData(entity_data)
}
</script>

<template>
    <RegistrationFrame header-title="Digital Accelerator">

      <template #form>
          <UsableBaseInput :is-full="false" @change="captureValue" placeholder="..." v-model="entity_data.accelerator_name" label="Digital Accelerator Name" />

        <div class="form-groups">
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.phone_number" label="Phone Number" />
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.email" label="Email" />
        </div>
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" type="date" placeholder="..." v-model="entity_data.date_establishment" label="Date Of Establishment" />
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.region_location"  label="Region" :options="regionsOptions" />
        </div>
        <div class="form-groups my-2">
          <p class="block text-gray-600 text-sm font-semibold mb-1" >Focus Areas | Sectors</p>
          <el-select
              v-model="entity_data.focus_area"
              multiple
              collapse-tags
              size="large"
              placeholder="Select Area of Focus"
              style="width: 300px"
          >
            <el-option
                v-for="item in focus_area_options"
                :key="item?.value"
                :label="item?.label"
                :value="item?.value"
            />
          </el-select>
        </div>
        <UsableBaseTextArea @change="captureValue" placeholder="..." v-model="entity_data.brief_description"  label="Business Brief Description"  />

      </template>

    </RegistrationFrame>
</template>

<style scoped>

</style>