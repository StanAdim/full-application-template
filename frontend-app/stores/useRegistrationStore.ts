import type { StartupData} from "~/types/interfaces";
import type {ComputedRef, UnwrapRef} from "vue";

export const useRegistrationStore = defineStore('registrationStore', () => {

    const globalStore = useGlobalDataStore()
    const startupData = ref<StartupData>(null)

    const getStartupData = computed(() => {return startupData.value})

    // Actions

    const assignStartupData = (registration: StartupData) => startupData.value = registration


    return {
        startupData,
        getStartupData,
        assignStartupData,

    }
})