import type {Credential, LoggedUser, Product, User} from "~/types/interfaces";
import {defineStore} from "pinia";
import {useApiFetch} from "~/composables/useApiFetch";
import type {ComputedRef} from "vue";
export const useAuthStore = defineStore('auth', ()=> {
    const  user = ref<User | null>(null)
    const isLoggedIn = computed(()=> !!user.value)
    const globalStore = useGlobalDataStore()
    const regStore = useRegistrationStore()

    const getLoggedUser = computed(()=>{return user.value?.user})
    const getLoggedUserProfile = computed(()=>{return user.value?.profile})
    const getUserProfileable = computed(()=>{return user.value?.profile?.profileable})
    const getUserRoles = computed(()=>{return user.value?.user?.roles})
    const getUserPermissions = computed(()=>{ return  user.value?.role?.permissions.map(obj => obj.code)})
    const getProfileCategoryName : ComputedRef<string> = computed(()=> getLoggedUserProfile.value?.profileable?.type)

    //Register
    async function register(passed_data : RegistrationInfo) : Promise <void> {
        globalStore.toggleBtnLoadingState(true)
        await useApiFetch("/sanctum/csrf-cookie");
        const response = await useApiFetch("/api/register-user-with-profile", {
            method: "POST",
            body: passed_data,
        });
        if(response?.data.value){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(response?.data.value?.message,'success')
            regStore.assignStartupData(null)
            regStore.assignHubData(null)
            regStore.assignAcceleratorData(null)
            regStore.assignGrassrootProgramData(null)
            navigateTo('/login')
        }else {
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(response?.error.value?.data?.message,'error')
            // console.log(response)
        }
    }
    //Fetch User
    async function fetchUser() : Promise {
        const {data,error} = await useApiFetch('/api/v1/user');
        if(data.value){
            user.value = data.value as LoggedUser
            if(getLoggedUser.value?.hasInfo == 0)
                globalStore.toggleUserInfoDialogStatus('on') //close Extra infoDialog
        }
        if (error.value){
            console.log(error.value.message, 'error')
        }
        return {data,error}
    }
    // Login
    async function login(credentials: Credential) : Promise {
        globalStore.toggleBtnLoadingState(true)
        await useApiFetch("/sanctum/csrf-cookie");
        const loginResponse = await useApiFetch('/login',{
            method: 'POST',
            body : credentials
        });
        console.log(loginResponse)
        if (loginResponse.status.value === 'success'){
            await fetchUser();
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage('Welcome back!!','success')
        if (user.value){
            //navigate base on rank
            getLoggedUser.value.rank === 'internal' ?
                navigateTo('/admin/dashboard') :
                navigateTo('/profile/dashboard');
        }
        }else {
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(loginResponse.error.value?.data?.message, 'error')
        }
        return loginResponse;
    }
    //Logout
    async function logout() : Promise <void>{
        globalStore.toggleBtnLoadingState(true)
        const logout =  await useApiFetch('/logout', {method: 'POST'});
        if (logout.status.value === 'success'){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage('You are logged out', 'warning')
            navigateTo('/login')
            user.value = null;
        }
        globalStore.toggleBtnLoadingState(false)
    }

    // resend Verification
    async function resendEmailVerification() : Promise{
        await useApiFetch("/sanctum/csrf-cookie");
        const {data,error} = await useApiFetch('/api/send-verification-email');
        if(data.value){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(data.value.message, 'success');
        }
        else {
            globalStore.assignAlertMessage(error.value.message, 'error');

        }
        return {data,error}
    }
    // resend Verification
    async function userEmailVerification(verificationKey:string) : Promise{
        globalStore.toggleContentLoaderState('on')

        await useApiFetch("/sanctum/csrf-cookie");
        const verifyResponse = await useApiFetch(`/api/verify-user-email-${verificationKey}`);
        if(verifyResponse.status.value === 'success'){
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(verifyResponse.data?.value.message, 'success');
        }
        else {
            globalStore.assignAlertMessage([[verifyResponse.error.value?.data?.message]], 'error');

        }
        globalStore.toggleContentLoaderState('off')
    }
    async function sendPasswordResetLink(userEmail : string) : Promise {
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch("/api/send-password-reset-link", {
            method: "POST",
            body: userEmail,
        });
        if(data.value){
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(data.value.message, 'success');
        }
        else {
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage([[error.value?.data?.message]], 'error');
        }
        return {data,error}
    }
    async function resetUserPassword(newUserPass : string): Promise {
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch("/api/reset-password", {
            method: "POST",
            body: newUserPass,
        });
        if(data.value){
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(data.value.message, 'success');
            navigateTo('/')
        }
        else {
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
        return {data,error}
    }
    // update user data
    async  function updateUserData (userKey: string , passedData : object): Promise {
        const  {data , error} = await  useApiFetch(`/api/admin-update-user-data/${userKey}`, {
            method:'post',
            body: passedData
        })
        if (data.value){
            globalStore.assignAlertMessage(data.value.message, 'success')
            console.log(data.value)
        }else{
            globalStore.assignAlertMessage(error.value.data?.message, 'warning')
        }
    }
    // update user Email
    async  function updateUseRole (userKey: string , roleId : string): Promise {
        const  {data , error} = await  useApiFetch(`/api/admin-update-user-role/${userKey}-${roleId}`)
        if (data.value){
            globalStore.assignAlertMessage(data.value.message, 'success')
            console.log(data.value)
        }else{
            globalStore.assignAlertMessage(error.value.data?.message, 'warning')
        }
    }

    async function updateUserAccount(passed_data: User) : Promise <void>{
        globalStore.toggleBtnLoadingState(true)
        const {data, error} = await useApiFetch(`/update-user`,{
            method: 'PATCH',
            body : passed_data
        });
        if(data.value){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(data.value?.message,'success')
            await fetchUser()
        }
        else {
            globalStore.handleApiError(error.value);
        }
    }
    async function changeUserPassword(passed_data: User) : Promise <void>{
        globalStore.toggleBtnLoadingState(true)
        const {data, error} = await useApiFetch(`/change-user-password`,{
            method: 'PATCH',
            body : passed_data
        });
        if(data.value){
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(data.value?.message,'success')
        }
        else {
            globalStore.handleApiError(error.value);
        }
    }
    return {
        user,login,isLoggedIn,
        logout,fetchUser,register,getLoggedUser,getUserRoles
        ,getUserPermissions,getLoggedUserProfile,
        getUserProfileable,
        getProfileCategoryName,
        updateUserAccount,changeUserPassword,
    }
})