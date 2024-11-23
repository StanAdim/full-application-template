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
    const sectors = ref([])
    const fundingStages = ref([])
    const regions = ref([])

    // Getters
    const getStartupsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.startups})
    const getHubsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.hubs})
    const getAcceleratorsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.accelerators})
    const getGrassrootsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.grassroots})
    const getSectors : ComputedRef<[]> = computed(() => {return sectors.value?.data})
    const getFundingStage : ComputedRef<[]> = computed(() => {return fundingStages.value?.data})
    const getRegions : ComputedRef<[]> = computed(() => {return regions.value?.data})

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
    }    // Actions
    async function retrieveSectors() : Promise<[]>{
        const {data,error} = await useApiFetch(`/api/ict-sectors`);
        if(data.value){
            sectors.value = data.value;
        }if(error.value) {
            globalStore.handleApiError(error.value)
        }
    }
    async function retrieveFundingStages() : Promise<[]>{
        const {data,error} = await useApiFetch(`/api/funding-stages`);
        if(data.value){
            fundingStages.value = data.value;
        }if(error.value) {
            globalStore.handleApiError(error.value)
        }
    }
    async function retrieveRegions() : Promise<[]>{
        const {data,error} = await useApiFetch(`/api/tanzania-regions`);
        if(data.value){
            regions.value = data.value;
        }if(error.value) {
            globalStore.handleApiError(error.value)
        }
    }
    return {
        getStartupsCount,
        getHubsCount,getAcceleratorsCount,getGrassrootsCount, retrieveProfileCount,
        getSectors,retrieveSectors,
        getFundingStage,retrieveFundingStages,
        retrieveRegions, getRegions,
    }
})