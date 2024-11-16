import type {Project} from "~/types/interfaces";

export const useProjectStore = defineStore('projectStore', () => {
    const globalStore = useGlobalDataStore()

    // States
    const projects = ref([])
    const singleProject = ref< Project>(null)

    //Computed
    const getAllProjects = computed(() => {return projects.value?.data})
    const getSingleProject = computed(() => {return singleProject.value})

    // Mutations
    async function retrieveAllProjects(per_page: number = 12, page : number = 1, search : string = '') : Promise <void>{
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/projects?per_page=${per_page}&page=${page}&search=${search}`);
        const response = data.value as ApiResponse
        if(data.value){
            globalStore.toggleLoadingState(false)
            globalStore.toggleContentLoaderState(false)
            projects.value = data.value
        }
        else{
            globalStore.handleApiError(error.value);
        }
    }
    async function retrieveSingleProfile(uid:string) : Promise <void>{
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/projects/project/${uid}`);
        if(data.value){
            globalStore.toggleLoadingState(false)
            globalStore.toggleContentLoaderState(false)
            singleProject.value = data.value?.data
        }
        else{
            globalStore.handleApiError(error.value);
        }
    }
    async function createUpdateProject(passed_data: Project) : Promise <void>{
        globalStore.toggleBtnLoadingState(true)
        const action = passed_data?.action
        const {data, error} = await useApiFetch(`/api/project/${action}`,{
            method: action === 'create' ? 'POST': 'PATCH',
            body : passed_data
        });
        if(data.value){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(data.value?.message,'success')
            navigateTo('/profile/projects')
        }
        else {
            globalStore.handleApiError(error.value);
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
        else  globalStore.handleApiError(error.value);

    }

    return {
        retrieveAllProjects,
        getAllProjects,
        createUpdateProject,
        getSingleProject,
        retrieveSingleProfile,
        handleProjectApproval
    }
})