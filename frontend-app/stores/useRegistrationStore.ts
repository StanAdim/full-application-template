import type { StartupData, HubData} from "~/types/interfaces";
import type {ComputedRef, UnwrapRef} from "vue";

export const useRegistrationStore = defineStore('registrationStore', () => {

    const globalStore = useGlobalDataStore()
    const startupData = ref<StartupData>(null)
    const HubData = ref<HubData>(null)

    const getStartupData = computed(() => {return startupData.value})
    const getHubData = computed(() => {return HubData.value})

    // Actions

    const assignStartupData = (registration: StartupData) => startupData.value = registration
    const assignHubData = (registration: HubData) => HubData.value = registration


    return {
        startupData,
        getStartupData,getHubData,
        assignStartupData,
        assignHubData,
    }
})