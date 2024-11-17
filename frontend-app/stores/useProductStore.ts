import type {Product} from "~/types/interfaces";

export const useProductStore = defineStore('productStore', () => {
    const globalStore = useGlobalDataStore()

    // States
    const products = ref([])
    const singleProduct = ref< Product>(null)

    //Computed
    const getAllProducts = computed(() => {return products.value?.data})
    const getSingleProduct = computed(() => {return singleProduct.value})

    // Mutations
    async function retrieveAllProducts(per_page: number = 12, page : number = 1, search : string = '') : Promise <void>{
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/products?per_page=${per_page}&page=${page}&search=${search}`);
        const response = data.value as ApiResponse
        if(data.value){
            globalStore.toggleLoadingState(false)
            globalStore.toggleContentLoaderState(false)
            products.value = data.value
        }
        else{
            globalStore.handleApiError(error.value);
        }
    }
    async function retrieveSingleProduct(uid:string) : Promise <void>{
        globalStore.toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/products/product/${uid}`);
        if(data.value){
            globalStore.toggleLoadingState(false)
            globalStore.toggleContentLoaderState(false)
            singleProduct.value = data.value?.data
        }
        else{
            globalStore.handleApiError(error.value);
        }
    }
    async function createUpdateProduct(passed_data: Product) : Promise <void>{
        globalStore.toggleBtnLoadingState(true)
        const action = passed_data?.action
        const {data, error} = await useApiFetch(`/api/product/${action}`,{
            method: action === 'create' ? 'POST': 'PATCH',
            body : passed_data
        });
        if(data.value){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(data.value?.message,'success')
            navigateTo('/profile/products')
        }
        else {
            globalStore.handleApiError(error.value);
        }
    }

    return {
        retrieveAllProducts,
        getAllProducts,
        createUpdateProduct,
        getSingleProduct,
        retrieveSingleProduct,
    }
})