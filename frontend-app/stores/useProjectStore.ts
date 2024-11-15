import type {Project} from "~/types/interfaces";

export const useProjectStore = defineStore('projectStore', () => {
    const globalStore = useGlobalDataStore()

    // States
    const projects = ref([])
    const singleProject = ref<ConferenceData | null>(null)

    //Computed
    const getAllProjects = computed(() => {return projects.value?.data})
    const getSingleProject = computed(() => {return singleProject.value})

    // Mutations
    async function retrieveAllProjects() : Promise <void>{
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/projects`);
        const response = data.value as ApiResponse
        if(data.value){
            globalStore.toggleLoadingState(false)
            globalStore.toggleContentLoaderState(false)
            projects.value = data.value
        }
        else{
            globalStore.toggleLoadingState(false)
            console.log(error.value)
            globalStore.toggleContentLoaderState(false)
        }
    }
    async function createUpdateProject(passed_data: Project) : Promise <void>{
        globalStore.toggleBtnLoadingState(true)
        const action = passed_data?.action
        const {data, error} = await useApiFetch(`/api/project/${action}`,{
            method: 'POST',
            body : passed_data
        });
        if(data.value){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(data.value?.message,'success')
            navigateTo('/profile/projects')
            await retrieveAllProjects()
        }
        else {
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(error.value?.data?.message,'error')
            console.log(error.value)
        }
    }
    async function handleProjectApproval (passId: string){
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/conference/change-status/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(data.value){
            globalStore.assignAlertMessage(dataResponse?.message, 'success')
            globalStore.toggleContentLoaderState(false)
            await retrieveAllProjects()
        }
    }
    async function fetchSingleProject(uid: string){
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/conference-data/${uid}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
            singleEventDetail.value = dataResponse.data
            globalStore.toggleContentLoaderState(false)
        }
        return {data, error};
    }
    return {
        retrieveAllProjects,
        getAllProjects,
        createUpdateProject,
        getSingleProject,
        fetchSingleProject,
        handleProjectApproval
    }
})