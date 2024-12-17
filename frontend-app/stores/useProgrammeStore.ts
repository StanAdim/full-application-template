
export const useProgrammeStore = defineStore('programmeStore', () => {
    const globalStore = useGlobalDataStore()

    // States
    const programmes = ref([])
    const singleProgramme = ref< Project>(null)

    //Computed
    const getAllProgramme = computed(() => {return programmes.value})
    const getSingleProgramme = computed(() => {return singleProgramme.value})

    // Mutations
    async function retrieveAllProgrammes(per_page: number = 12, page : number = 1, search : string = '') : Promise <void>{
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/programmes?per_page=${per_page}&page=${page}&search=${search}`);
        if(data.value){
            globalStore.toggleLoadingState(false)
            globalStore.toggleContentLoaderState(false)
            programmes.value = data.value?.data
        }
        else{
            globalStore.handleApiError(error.value);
        }
    }
    async function retrieveSingleProgramme(uid:string) : Promise <void>{
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/programmes/programme/${uid}`);
        if(data.value){
            globalStore.toggleLoadingState(false)
            globalStore.toggleContentLoaderState(false)
            singleProgramme.value = data.value?.data
        }
        else{
            globalStore.handleApiError(error.value);
        }
    }
    async function createUpdateProgramme(passed_data: Project) : Promise <void>{
        globalStore.toggleBtnLoadingState(true)
        const action = passed_data?.action
        const {data, error} = await useApiFetch(`/api/programme/${action}`,{
            method: action === 'create' ? 'POST': 'PATCH',
            body : passed_data
        });
        if(data.value){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(data.value?.message,'success')
            navigateTo('/profile/programmes')
        }
        else {
            globalStore.handleApiError(error.value);
        }
    }

    return {
        retrieveAllProgrammes,
        getAllProgramme,
        createUpdateProgramme,
        getSingleProgramme,
        retrieveSingleProgramme,
    }
})