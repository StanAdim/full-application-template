import type {Credential, LoggedUser, User} from "~/types/interfaces";
import {defineStore} from "pinia";
import {useApiFetch} from "~/composables/useApiFetch";
export const useAuthStore = defineStore('auth', ()=> {
    const  user = ref<User | null>(null)
    const isLoggedIn = computed(()=> !!user.value)
    const globalStore = useGlobalDataStore()

    const getLoggedUser = computed(()=>{return user.value?.user})
    const getLoggedUserProfile = computed(()=>{return user.value?.profile})
    const getUserProfileable = computed(()=>{return user.value?.profileable})
    const getUserRole = computed(()=>{return user.value?.role?.name})
    const getUserPermissions = computed(()=>{
        return  user.value?.role?.permissions.map(obj => obj.code)})
    //Fetch Logout
    async function fetchUser(){
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
    // Login
    async function login(credentials: Credential) : Promise{
        globalStore.toggleBtnLoadingState(true)
        await useApiFetch("/sanctum/csrf-cookie");
        const loginResponse = await useApiFetch('/login',{
            method: 'POST',
            body : credentials
        });
        if (loginResponse.status.value === 'success'){
            await fetchUser();
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage('Welcome back!!','success')
        if (user.value){
            navigateTo('/profile/dashboard');
        }
        }else {
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(loginResponse.error.value?.data?.message, 'error')
        }
        return loginResponse;
    }
    //Logout
    async function logout(){
        const logout =  await useApiFetch('/logout', {method: 'POST'});
        if (logout.status.value === 'success'){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage('You are logged out', 'warning')
            user.value = null;
            navigateTo('/login')
            location.reload()
        }
    }
    //Register
    async function register(passed_data : RegistrationInfo){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch("/api/register-user-with-profile", {
            method: "POST",
            body: passed_data,
        });
        if(data.value){
            globalStore.assignAlertMessage(data.value?.message,'success')
        }else {
            globalStore.assignAlertMessage(error.value?.statusMessage,'error')
        }
        console.log(data.value,error.value?.statusMessage)
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
    return {
        user,login,isLoggedIn,
        logout,fetchUser,register,getLoggedUser,getUserRole
        ,getUserPermissions,getLoggedUserProfile,
        getUserProfileable,

    }
})