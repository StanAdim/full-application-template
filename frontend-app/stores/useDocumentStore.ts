import {useApiFetch} from "~/composables/useApiFetch";

export const useDocumentStore = defineStore('documentStore', () => {

    const globalStore = useGlobalDataStore()

    // states
    const docList = ref(null)
    const documentCategories = ref([])

    // Getters
    const getDocumentList : ComputedRef<[]> = computed(() => {return docList.value})
    const getDocTypes : ComputedRef<[]> = computed(() => {return documentCategories.value?.data})

    // Actions
    async function retrieveSingleDoc (uid:string) : Promise<void>{
        console.log(uid);
    }
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
    async function retrieveDocumentTypes() : Promise<[]>{
        const {data,error} = await useApiFetch(`/api/document-types`);
        if(data.value){
            documentCategories.value = data.value;
        }if(error.value) {
            globalStore.handleApiError(error.value)
        }
    }
    const uploadNewDocument = async (passedData) : Promise => {try {
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
    return {
        getDocumentList,getDocTypes,
        retrieveDocuments,
        retrieveSingleDoc,
        retrieveDocByName,deleteDoc,
        updateDocStatus,uploadNewDocument, retrieveDocumentTypes

    }
})