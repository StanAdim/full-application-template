import type { StartupData, HubData, AcceleratorData, GrassrootProgramsData} from "~/types/interfaces";

export const useRegistrationStore = defineStore('registrationStore', () => {

    const globalStore = useGlobalDataStore()
    const startupData = ref<StartupData>(null)
    const HubData = ref<HubData>(null)
    const acceleratorData = ref<AcceleratorData>(null)
    const grassrootProgramData = ref<GrassrootProgramsData>(null)

    const getStartupData = computed(() => {return startupData.value})
    const getHubData = computed(() => {return HubData.value})
    const getAcceleratorData = computed(() => {return acceleratorData.value})
    const getGrassrootProgramData = computed(() => {return grassrootProgramData.value})

    // Actions

    const assignStartupData = (registration: StartupData) => startupData.value = registration
    const assignHubData = (registration: HubData) => HubData.value = registration
    const assignAcceleratorData = (registration: AcceleratorData) => acceleratorData.value = registration
    const assignGrassrootProgramData = (registration: GrassrootProgramsData) => grassrootProgramData.value = registration


    return {
        startupData,
        getStartupData,getHubData,getAcceleratorData,
        getGrassrootProgramData,
        assignStartupData,
        assignHubData,
        assignAcceleratorData,
        assignGrassrootProgramData,
    }
})