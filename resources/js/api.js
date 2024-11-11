import axios from "axios";
import { ref,  watchEffect } from "vue"



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
                    router.replace('/users/login');
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
                    .then(refreshResponse => {
                        console.log(refreshResponse,'99999')
                        const newToken = refreshResponse.data.access_token;
                        localStorage.setItem('access_token', newToken);

                        accessToken.value = newToken; // Update the reactive variable
                        fetchUser();




                    })


                }


                // else if (error.response.status === 403) {
                //     window.location.href ='/permission';
                // }
                console.log("respons error")
                return Promise.reject(error);
            }

        )

        api.value =apiInstance


}


// Watch for changes in localStorage
// watch(
//     () => localStorage.getItem('access_token'), // Watch the access_token in localStorage
//     (newToken, oldToken) => {
//         console.log(newToken,33333333)
//         if (newToken !== oldToken) {
//             console.log("Access token changed:", newToken);
//             accessToken.value = newToken; // Update the reactive variable when localStorage changes
//         }
//     },
//     { immediate: true } // Run immediately on setup
// );
const fetchUser = () => {
    const token = localStorage.getItem('access_token');
    if (token) {
        console.log(4444444444)
        console.log(22)
        return axios.post('/api/auth/me',{},{
            headers:{
                'authorization': `Bearer ${localStorage.getItem('access_token')}`
            }
        })
        .then(res => {
            console.log(res,'33333')
            userMe.value=res.data
        })

    }
  };
  watchEffect(() => {
    const token = localStorage.getItem("access_token");
    if (token) {
        fetchUser(); // Fetch user data whenever token changes
    } else {
        userMe.value = ""; // Clear user data if no token is present
    }
});
export default api;
export { initApi,
    //  userMe
      };


