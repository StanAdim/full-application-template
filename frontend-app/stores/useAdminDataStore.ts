import type {ApiResponse, LoggedUser} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";
import type {ComputedRef} from "vue";
import type {Integer} from "type-fest";

export const useAdminDataStore = defineStore('adminStore', () => {

    const globalStore = useGlobalDataStore()
    const projectStore = useProjectStore()
    const productStore = useProductStore()

    // states
    const profiles = ref({ startups: [], hubs: [], accelerators: [], grassroots: []})
    const singleProfile = ref(null)

    // Getters
    const getStartupList : ComputedRef<[]> = computed(() => {return profiles.value?.startups})
    const getHubList : ComputedRef<[]> = computed(() => {return profiles.value?.hubs})
    const getAcceleratorList : ComputedRef<[]> = computed(() => {return profiles.value?.accelerators})
    const getGrassrootList : ComputedRef<[]> = computed(() => {return profiles.value?.grassroots})
    const getSingleProfile : ComputedRef<[]> = computed(() => {return singleProfile.value})

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
    const retrieveSingleProfile = async (type:string, uid) : Promise < Integer > => {
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/admin/profile-details/${type}/${uid}`);
        if(data.value ){
            globalStore.toggleContentLoaderState(false)
            singleProfile.value = data.value?.data
        }
        else{
            console.log(error.value?.data)
            globalStore.toggleContentLoaderState(false)
            globalStore.handleApiError(error.value);
        }
    }
    async function switchApprovalStatus (item: string, passed_uid: string): Promise{
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/admin/change-status/${item}/${passed_uid}`);
        if(data.value){
            globalStore.assignAlertMessage(data.value?.message, 'success')
            globalStore.toggleContentLoaderState(false)
            switch (item){
                case  'projects':{
                    await projectStore.retrieveAllProjects()
                    break;
                }
                case  'products':{
                    await productStore.retrieveAllProducts()
                    break;
                }
                case  'startups':{
                    await retrieveProfileList('startups')
                    break;
                }
                case  'hubs':{
                    await retrieveProfileList('hubs')
                    break;
                }
                case  'accelerators':{
                    await retrieveProfileList('accelerators')
                    break;
                }
                case  'grassroots':{
                    await retrieveProfileList('grassroots')
                    break;
                }
            }
        }
        else  globalStore.handleApiError(error.value);
    }

    return {
        getStartupList,
        getHubList,getAcceleratorList,getGrassrootList,
        retrieveProfileList,
        getSingleProfile,
        retrieveSingleProfile,
        switchApprovalStatus,
    }
})