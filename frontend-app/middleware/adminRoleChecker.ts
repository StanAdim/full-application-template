
export default defineNuxtRouteMiddleware((to, from) => {
    const auth = useAuthStore();
    const globalStore = useGlobalDataStore();
    if (auth.getLoggedUser.rank !== 'internal') {
        globalStore.assignAlertMessage('Not Allowed resource', 'warning')
        return navigateTo("/profile/dashboard", {replace: true});
    }
})