import {useProductStore} from "~/stores/useProductStore";
import type {Integer} from "type-fest";

export const useGlobalDataStore = defineStore('globalData', () => {
    const authStore = useAuthStore()
    const projectStore = useProjectStore()
    const productStore = useProductStore()
    const localLoader = ref<boolean>(false);
    const alertMessage = ref<string>('');
    const pageTitle = ref<string>('');

    const isContentLoading = ref<boolean>(false)
    const btnLoadingState = ref<boolean>(false)
    const isLoading = ref<boolean>(false);
    const longName = ref<string>('Tanzania Startups')

    const appRoutes  = ref([
        {name: 'Dashboard', path: '/crm/', userRole: '', isActiveLink:true},
    ])

    //computed property
    const getLoadingState = computed(() => {return isLoading.value})
    const getAlertMessage = computed(() => {return alertMessage.value})
    const getAppName = computed(()=> longName.value)
    const getAppRoute = computed(() => {return appRoutes.value})
    const getPageTitle = computed(() => {return pageTitle.value})
    const getContentLoadingState = computed(() => {return isContentLoading.value})
    const getBtnLoadingState = computed(() => {return btnLoadingState.value})

    // Actions
    const toggleLoadingState = (state : boolean) :boolean => isLoading.value = state
    const toggleContentLoaderState = (state : boolean) : boolean => isContentLoading.value = state
    const toggleBtnLoadingState = (state : boolean) : boolean =>  btnLoadingState.value = state
    const toggleLocalLoaderStatus = (state : boolean) : boolean =>  localLoader.value = state
    const assignPageTitle = (title : string) : string =>  pageTitle.value = title
    function handleApiError(error: any, alertType: "error" | "success" = "error") {
        console.error(error);
        toggleBtnLoadingState(false)
        toggleLoadingState(false)
        toggleContentLoaderState(false)
        if (error) { assignAlertMessage(error?.data?.message,'error')}
    }
    const deleteItemInDB = async (uid: string, item:string) : Promise < void> => {
        toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/${item}-delete/${uid}`,
            { method: 'DELETE'});
        if(data.value ){
            toggleContentLoaderState(false)
           switch (item){
               case  'project':{
                   await projectStore.retrieveAllProjects()
                   break;
               }
               case  'product':{
                   await productStore.retrieveAllProducts()
                   break;
               }
           }
        }
        else{
            console.log(error.value?.data)
            toggleContentLoaderState(false)
            globalStore.assignAlertMessage(error.value?.message,'error')
        }
    }
    const statsOfItem = async (item:string) : Promise < Integer > => {
        toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/${item}-count`);
        if(data.value ){
            toggleContentLoaderState(false)
           return data.value?.count
        }
        else{
            console.log(error.value?.data)
            toggleContentLoaderState(false)
            globalStore.assignAlertMessage(error.value?.message,'error')
        }
    }
    async function switchApprovalStatus (passId: string, item: string){
        toggleContentLoaderState(true)
        const {data, error} = await useApiFetch(`/api/${item}/change-status/${passId}`);
        if(data.value){
            assignAlertMessage(data.value?.message, 'success')
            toggleContentLoaderState(false)
            switch (item){
                case  'project':{
                    await projectStore.retrieveAllProjects()
                    break;
                }
                case  'product':{
                    await productStore.retrieveAllProducts()
                    break;
                }
            }
        }
        else  handleApiError(error.value);
    }

    // Extra functionalities
    const assignAlertMessage = (message,type)=> {
        alertMessage.value = message
        const elementNotify = () => {
            ElNotification({
                title: 'Alert',
                showClose: false,
                offset: 5,
                message: message,
                type: type,
                // position: 'bottom-right',
            })
        }
        elementNotify()
    }
    function separateNumber(passedNum) {
        if (passedNum === undefined || passedNum === null) throw new TypeError("Input number is undefined or null");
        if (typeof passedNum !== 'number' && typeof passedNum !== 'string')  throw new TypeError("Input must be a number or a string representing a number");
        // Convert to number first if it's a string representing a number
        let num = Number(passedNum);
        if (isNaN(num)) {
            throw new TypeError("Input is not a valid number");
        }
        let numStr = num.toString();
        numStr = numStr.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return numStr;
    }
    const hasPermission = (permissionCode)=> {   return authStore.getUserPermissions.includes(permissionCode)}
    function shortenText(text, wordLimit) {
        const words = text.split(' ');
        if (words.length > wordLimit) {
            return words.slice(0, wordLimit).join(' ') + '...';
        }
        return text;  // Return original text if it's already short enough
    }

    const getYearsArray = computed(() => {
        const startYear = 2002;
        const yearsArray = [];
        for (let year = startYear; year <= new Date().getFullYear(); year++) {
            yearsArray.push({ label: year.toString(), value: year });
        }
        return yearsArray;
    });
    return {
        getAppName,
        getLoadingState, getAlertMessage,
        getAppRoute, getContentLoadingState,
        getBtnLoadingState,
        hasPermission,
        shortenText,separateNumber,
        assignAlertMessage,
        toggleLoadingState, toggleContentLoaderState,
        toggleLocalLoaderStatus, toggleBtnLoadingState,
        assignPageTitle,getPageTitle,getYearsArray,
        deleteItemInDB, handleApiError, statsOfItem,
        switchApprovalStatus
    }
})