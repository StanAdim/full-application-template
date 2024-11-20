import type {ApiResponse, LoggedUser} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";
import type {ComputedRef} from "vue";

export const useAdminDataStore = defineStore('adminStore', () => {

    const globalStore = useGlobalDataStore()

    // states
    const profiles = ref({ startups: [], hubs: [], accelerators: [], grassroots: []})

    // Getters
    const getStartupList : ComputedRef<[]> = computed(() => {return profiles.value?.startups})
    const getHubList : ComputedRef<[]> = computed(() => {return profiles.value?.hubs})
    const getAcceleratorList : ComputedRef<[]> = computed(() => {return profiles.value?.accelerators})
    const getGrassrootList : ComputedRef<[]> = computed(() => {return profiles.value?.grassroots})

    // Actions
    async function retrieveProfileList( type : string = '', per_page: number = 12, page : number = 1, search : string = '') : Promise<[]>{
        globalStore.toggleContentLoaderState(true)
        const {data,error} = await useApiFetch(`/api/admin/profiles/${type}?per_page=${per_page}&page=${page}&search=${search}`);
        if(data.value){
            profiles.value[type] = data.value?.data;
            globalStore.toggleContentLoaderState(false)
        }if(error.value) {
            globalStore.handleApiError(error.value);
        }
    }
    return {
        getStartupList,
        getHubList,getAcceleratorList,getGrassrootList,
        retrieveProfileList,
    }
})