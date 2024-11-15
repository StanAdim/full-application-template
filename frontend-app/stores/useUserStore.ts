import type {ApiResponse, LoggedUser} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";
import type {ComputedRef} from "vue";

export const useUserStore = defineStore('userStore', () => {

    const globalStore = useGlobalDataStore()

    // states
    const userList = ref(null)

    // Getters
    const getUserList : ComputedRef<[]> = computed(() => {return userList.value})

    // Actions
    async function retrieveUserList(per_page: number = 12, page : number = 1, search : string = '') : Promise<[]>{
        globalStore.toggleContentLoaderState(true)
        const {data,error} = await useApiFetch(`/api/admin/user-list?per_page=${per_page}&page=${page}&search=${search}`);
        if(data.value){
            // globalStore.assignAlertMessage(data.value.message, 'success')
            userList.value = data.value?.data
            globalStore.toggleContentLoaderState(false)

        }else {
            console.log(error.value)
            globalStore.toggleContentLoaderState(false)
        }
    }
    return {
        getUserList,
        retrieveUserList
    }
})