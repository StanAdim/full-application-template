<script setup lang="ts">
import RegistrationFrame from "~/components/usable/RegistrationFrame.vue";

definePageMeta({
  title: 'Register',
      layout: 'guest',
})
const globalData = useGlobalDataStore()
const regStore = useRegistrationStore()

const regionsOptions = [{  label : 'Arusha', value: '1'}, {  label : 'Mwanza', value: '2'}, ]
const membership_options = [{  label : 'Paid', value: '1'}, {  label : 'Free', value: '2'}, ]
const program_options = [
    {  label : 'Incubation', value: 'Incubation'},
  {  label : 'Acceleration', value: 'Acceleration'},
  {  label : 'Mentorship', value: 'Mentorship'},
  {  label : 'Networking events', value: 'Networking events'},
]
const activeTab = ref(1)
const entity_data = reactive({
  hub_name: '',
  total_members: '',
  number_female: '',
  membership_option: '',
  date_establishment: '',
  region_location: '',
  phone_number: '',
  email: '',
  available_programs: '',
  brief: '',
})

const captureValue = () => {
  regStore.assignHubData(entity_data)
}
</script>

<template>
    <RegistrationFrame header-title="Innovation Hub">
      <template #form>
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.hub_name" label="Hub Name" />
          <UsableBaseInput @change="captureValue" placeholder="1"  type="number" v-model="entity_data.total_members"  label="Members Size"  />
        </div>
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" placeholder="1"  type="number" v-model="entity_data.number_female"  label="Female Members"  />
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.membership_option"  label="Membership Option" :options="membership_options" />
        </div>
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.phone_number" label="Hub Phone Number" />
          <UsableBaseInput @change="captureValue" placeholder="..." v-model="entity_data.email" label=" Hub Email" />
        </div>
        <div class="form-groups">
          <UsableBaseInput @change="captureValue" type="date" placeholder="..." v-model="entity_data.date_establishment" label="Date Of Establishment" />
          <UsableBaseSelect @change="captureValue" placeholder="..." v-model="entity_data.region_location"  label="Region" :options="regionsOptions" />
        </div>
        <div class="form-groups my-2">
            <p class="block text-gray-600 text-sm font-semibold mb-1" >Available Programmes</p>
            <el-select
                v-model="entity_data.available_programs"
                multiple
                collapse-tags
                size="large"
                placeholder="Select"
                style="width: 300px"
            >
              <el-option
                  v-for="item in program_options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
              />
            </el-select>
        </div>
        <UsableBaseTextArea @change="captureValue" placeholder="..." v-model="entity_data.brief"  label="Hub Brief Description"  />

      </template>
    </RegistrationFrame>
</template>

<style scoped>

</style>