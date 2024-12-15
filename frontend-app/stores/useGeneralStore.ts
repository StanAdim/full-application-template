import type {ApiResponse, LoggedUser} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";
import type {ComputedRef} from "vue";
import {useDocumentStore} from "~/stores/useDocumentStore";

export const useGeneralStore = defineStore('generalStore', () => {

    const globalStore = useGlobalDataStore()
    const documentStore = useDocumentStore()

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
    const blobDataFile = ref(null)
    const blobDataName = ref('')

    // Getters
    const getStartupsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.startups})
    const getHubsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.hubs})
    const getAcceleratorsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.accelerators})
    const getGrassrootsCount : ComputedRef<[]> = computed(() => {return profileCounts.value?.grassroots})
    const getSectors : ComputedRef<[]> = computed(() => {return sectors.value?.data})
    const getFundingStage : ComputedRef<[]> = computed(() => {return fundingStages.value?.data})
    const getRegions : ComputedRef<[]> = computed(() => {return regions.value?.data})
    const getBlobDataFile : ComputedRef<[]> = computed(() => {return blobDataFile.value})
    const getBlobDataFileName : ComputedRef<[]> = computed(() => {return blobDataName.value})

    // Actions
    const resetBlobData = () => {
        blobDataName.value = '';
        blobDataFile.value = null
    }
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
    //handle file preview

    const previewFile = async (file_data) : Promise => {
        documentStore.togglePreviewModalStatus(true)
        globalStore.toggleContentLoaderState(true);
        blobDataName.value = file_data.name
        let headers: any = {
            accept: "application/json",
            // Authorization: `Bearer ${authStore.getAccessToken}`,
        };
        const { data, error } = await useApiFetch(`/api/preview-document?name=`+file_data.path, { ...headers });
        const blob = URL.createObjectURL(data.value as Blob);
        blobDataFile.value = blob;
        globalStore.toggleContentLoaderState(false);
        if(error.value){
            console.log(error.value)
        }
    };
    return {
        getStartupsCount,
        getHubsCount,getAcceleratorsCount,getGrassrootsCount, retrieveProfileCount,
        getSectors,retrieveSectors,
        getFundingStage,retrieveFundingStages,
        retrieveRegions, getRegions,
        getBlobDataFileName,getBlobDataFile,previewFile, resetBlobData,
    }
})