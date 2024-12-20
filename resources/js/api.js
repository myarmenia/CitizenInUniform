import axios from "axios";
import { ref } from "vue"



const api = ref()
const accessToken = ref(localStorage.getItem('access_token')); // Store the token in a reactive variable
const userMe = ref(null); // Store user credentials in a reactive variable
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
                    console.log('status')
                    router.replace('/login');
                }
                console.log(66666)
                console.log(error.response.data.message)
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
                console.log(3232)

                if(error.response.data.message==="Token has expired"){
                    console.log('expired')
                    return axios.post('/api/auth/refresh',{},{
                        headers:{
                            'authorization': `Bearer ${localStorage.getItem('access_token')}`
                        }
                    })
                    .then(res => {
                        console.log(res,'99999')
                        const newToken = res.data.access_token;
                        localStorage.setItem('access_token', newToken);

                        accessToken.value = newToken; // Update the reactive variable

                        error.config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`
                        console.log(error.config.headers)
                        return  apiInstance.request(error.config.headers)

                    })


                }



                if (error.response) {
                    if (error.response.status === 403) {

                        toast.fire({ icon: 'error', title: 'Դուք չունեք բավարար թույլատվությունը' });
                        router.push('/permission');
                    }

                } else {
                    console.error('Unexpected error:', error);
                }

                console.log("respons error")
                return Promise.reject(error);
            }

        )

        api.value =apiInstance


}


export default api;
export { initApi};


