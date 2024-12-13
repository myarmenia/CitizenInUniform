
import api, { initApi } from "./api";

export function logoutFunction(router){


    const logout = async () => {
        try {
            await api.value.post('/api/auth/logout');
            sessionStorage.removeItem('access_token');
            window.location.href = '/login';
        } catch (error) {
            errorMessage.value = error
        }
    };
    return {logout}

}
