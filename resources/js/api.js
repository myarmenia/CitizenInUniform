import axios from "axios";
import { ref} from "vue"



const api = ref()
const initApi = (router) => {

    const apiInstance = axios.create()
        //start request
        apiInstance.interceptors.request.use(
            config=>{
                const token = localStorage.getItem('access_token');
                if (token) {
                    config.headers = config.headers || {};
                    config.headers.Authorization = `Bearer ${token}`; // Set the Authorization header
                }
                return config
            },
            error=>{

                console.log(error.response)
                if(error.response.status==401){

                    router.replace('/users/login');
                }
            }

        )
        // end request

        apiInstance.interceptors.response.use(
            config=>{

                const token = localStorage.getItem('access_token');
                if (token) {
                    console.log('8545')

                    config.headers = config.headers || {};
                    config.headers.Authorization = `Bearer ${token}`; // Set the Authorization header

                }

                return config
            },
            error=>{

                if (error.response.status === 401) {

                    window.location.href ='/users/login'
                }
                else if (error.response.status === 403) {
                    window.location.href ='/permission';
                }
                console.log("respons error")
                return Promise.reject(error);
            }

        )
        api.value =apiInstance

}
export default api;
export { initApi };


