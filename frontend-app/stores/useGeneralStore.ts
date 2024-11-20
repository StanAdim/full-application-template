import type {ApiResponse, LoggedUser} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";
import type {ComputedRef} from "vue";

export const useGeneralStore = defineStore('generalStore', () => {

    const globalStore = useGlobalDataStore()

    // states
    const profileCounts = ref({
        startups: 0,
        hubs: 0,
        accelerators: 0,
        grassroots: 0,
    })

    // Getters
    const getStartupsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.startups})
    const getHubsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.hubs})
    const getAcceleratorsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.accelerators})
    const getGrassrootsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.grassroots})

    // Actions
    async function retrieveProfileCount( type : string = '') : Promise<[]>{
        globalStore.toggleContentLoaderState(true)
        const {data,error} = await useApiFetch(`/api/profile/${type}-count`);
        if(data.value){
            profileCounts.value[type] = data.value?.count;
            globalStore.toggleContentLoaderState(false)
        }if(error.value) {
            console.log(error.value)
            globalStore.toggleContentLoaderState(false)
        }
    }
    return {
        getStartupsCount,
        getHubsCount,getAcceleratorsCount,getGrassrootsCount,
        retrieveProfileCount,
    }
})