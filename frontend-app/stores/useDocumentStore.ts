import {useApiFetch} from "~/composables/useApiFetch";

export const useDocumentStore = defineStore('documentStore', () => {

    const globalStore = useGlobalDataStore()

    // states
    const docList = ref(null)
    const documentCategories = ref([])
    const previewModalStatus = ref(false)

    // Getters
    const getDocumentList : ComputedRef<[]> = computed(() => {return docList.value})
    const getPreviewModalState : ComputedRef<[]> = computed(() => {return previewModalStatus.value})
    const getDocTypes : ComputedRef<[]> = computed(() => {return documentCategories.value?.data})

    // Actions
    const togglePreviewModalStatus  = (state:boolean) : Boolean =>  previewModalStatus.value = state
    async function retrieveDocuments(per_page: number = 12, page : number = 1, search : string = '') : Promise<[]>{
        globalStore.toggleContentLoaderState(true)
        const {data,error} = await useApiFetch(`/api/documents?per_page=${per_page}&page=${page}&search=${search}`);
        if(data.value){
            // globalStore.assignAlertMessage(data.value.message, 'success')
            docList.value = data.value?.data
            globalStore.toggleContentLoaderState(false)
        }else {
            console.log(error.value)
            globalStore.toggleContentLoaderState(false)
        }
    }
    const uploadNewDocument = async (passedData) : Promise => {
        try {
            const { data, error } = await useApiFetch('/api/upload-document', {
                method: 'POST',
                body: passedData,
                headers: {
                    // 'Content-Type': "multipart/form-data"
                }
            });
            if(data.value){
                const message = 'Document uploaded successfully!';
                await  retrieveDocuments()
                globalStore.toggleBtnLoadingState(false);
                globalStore.assignAlertMessage(message, 'success');
                navigateTo('/profile/documents')
            }
            if(error.value){
                globalStore.toggleBtnLoadingState(false);
                globalStore.assignAlertMessage(error.value?.message, 'error');
            }
        } catch (err) {
            console.log(error)
            const message = 'Failed to upload document.';
            globalStore.toggleBtnLoadingState(false);
            globalStore.assignAlertMessage(message, 'error');
        }
    }
    async function retrieveDocByName(name: string) : Promise {
        globalStore.toggleContentLoaderState(true)
        const { data, error } = await useApiFetch(`/api/document/${name}`);
        if(data.value){
            globalStore.toggleContentLoaderState(false);
            return data.value?.data;
        }
        else {
            globalStore.toggleContentLoaderState(false);
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
            return null;
        }
    }
    async function deleteDoc(docId : string) : Promise {
        globalStore.toggleContentLoaderState(true)
        const { data, error } = await useApiFetch(`/api/document-delete-${docId}`, {
            method: 'DELETE'
        });
        if(data.value){
            await  retrieveDocuments()
            globalStore.toggleContentLoaderState(false);
        }
        else {
            globalStore.toggleContentLoaderState(false);
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }
    async function updateDocStatus(docId : string) : Promise {
        globalStore.toggleContentLoaderState(true)
        const { data, error } = await useApiFetch(`/api/document-update-${docId}`, {
            method: 'PUT'
        });
        if(data.value){
            await  retrieveDocuments()
            globalStore.toggleContentLoaderState(false);
        }
        else {
            globalStore.toggleContentLoaderState(false);
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }

    // Document types Functions
    async function retrieveDocumentTypes() : Promise<[]>{
        const {data,error} = await useApiFetch(`/api/document-types`);
        if(data.value){
            documentCategories.value = data.value;
        }if(error.value) {
            globalStore.handleApiError(error.value)
        }
    }
    async function createUpdateDocumentType(passed_data: object) : Promise <void>{
        globalStore.toggleBtnLoadingState(true)
        const action = passed_data?.action
        const {data, error} = await useApiFetch(`/api/admin/${action}-document-type`,{
            method: action === 'create' ? 'POST': 'PATCH',
            body : passed_data
        });
        if(data.value?.success){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(data.value?.message,'success')
            await retrieveDocumentTypes()
        }
        else {
            globalStore.handleApiError(error.value);
        }
    }
    async function deleteDocType(docTypeId : string) : Promise {
        globalStore.toggleContentLoaderState(true)
        const { data, error } = await useApiFetch(`/api/admin/delete-document-type/${docTypeId}`, {
            method: 'DELETE'
        });
        if(data.value?.success){
            await  retrieveDocumentTypes()
            globalStore.toggleContentLoaderState(false);
            globalStore.assignAlertMessage(data.value?.message, 'success')
        }
        else {
            globalStore.toggleContentLoaderState(false);
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }




    return {
        getDocumentList,getDocTypes,
        togglePreviewModalStatus, getPreviewModalState,
        retrieveDocuments,
        retrieveDocByName,deleteDoc,
        updateDocStatus,uploadNewDocument,
        retrieveDocumentTypes, createUpdateDocumentType,
        deleteDocType,
    }
})