import type {Credential, LoggedUser, User} from "~/types/interfaces";
import {defineStore} from "pinia";
import {useApiFetch} from "~/composables/useApiFetch";
export const useAuthStore = defineStore('auth', ()=> {
    const  user = ref<User | null>(null)
    const isLoggedIn = computed(()=> !!user.value)
    const globalStore = useGlobalDataStore()
    const authErrors = ref <any | null>(null)

    const getLoggedUser = computed(()=>{return user.value?.user})
    const getLoggedUserInfo = computed(()=>{return user.value?.userInfo})
    const getAuthErrors = computed(()=>{return authErrors.value})
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
        await useApiFetch("/sanctum/csrf-cookie");
        const loginResponse = await useApiFetch('/login',{
            method: 'POST',
            body : credentials
        });
        if (loginResponse.status.value === 'success'){
            await fetchUser();
            // globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage('Welcome back!!','success')
        if (user.value){
            navigateTo('/profile/');
        }
        }else {
            authErrors.value = loginResponse.error.value
            globalStore.toggleLoadingState('off')
            // globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(authErrors.value?.data?.message, 'error')
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
            navigateTo('/')
            location.reload()
        }
    }
    //Register
    async function register(userInfo : RegistrationInfo){
        await useApiFetch("/sanctum/csrf-cookie");
        const registrationResponse = await useApiFetch("/register", {
            method: "POST",
            body: userInfo,
        });
        if(registrationResponse?.data.value?.code == 200){
            globalStore.assignAlertMessage('Registration Success: Check your Email','success')
            globalStore.toggleRegistrationForm()
        }else{
            authErrors.value = registrationResponse?.error.value?.data
            globalStore.assignAlertMessage(authErrors.value?.message, 'error')
        }
        return registrationResponse;
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
        user,login,isLoggedIn,getAuthErrors,
        logout,fetchUser,register,getLoggedUser,getUserRole
        ,getUserPermissions,getLoggedUserInfo,

    }
})