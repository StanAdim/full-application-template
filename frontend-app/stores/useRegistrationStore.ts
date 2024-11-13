import type { StartupData, HubData, AcceleratorDatav} from "~/types/interfaces";
import type {ComputedRef, UnwrapRef} from "vue";

export const useRegistrationStore = defineStore('registrationStore', () => {

    const globalStore = useGlobalDataStore()
    const startupData = ref<StartupData>(null)
    const HubData = ref<HubData>(null)
    const acceleratorData = ref<AcceleratorData>(null)

    const getStartupData = computed(() => {return startupData.value})
    const getHubData = computed(() => {return HubData.value})
    const getAcceleratorData = computed(() => {return acceleratorData.value})

    // Actions

    const assignStartupData = (registration: StartupData) => startupData.value = registration
    const assignHubData = (registration: HubData) => HubData.value = registration
    const assignAcceleratorData = (registration: AcceleratorData) => acceleratorData.value = registration


    return {
        startupData,
        getStartupData,getHubData,getAcceleratorData,
        assignStartupData,
        assignHubData,
        assignAcceleratorData,
    }
})