import axios from "axios";
import { ref, onMounted} from "vue";
import api, { initApi } from "./api";


export function me (router){

    const userMe=ref("");
    const userRoles=ref([]);
    const errorMessage=ref("");

    initApi(router);


    const me = async () => {
        try {
        let response = await api.value.post('/api/auth/me');
        let result = response.data
        userMe.value = result
        if(result.message!=null){

            toast.fire({icon:"error",title:result.message,
                showCloseButton: true,
                timer: 7000, // Optional: duration of the toast on screen (in ms)
                timerProgressBar: true, // Show progress bar

            } )

        }


        } catch (error) {
        errorMessage.value = error

        }
    }

    onMounted( async () =>{
        me()
        // console.log(me)
    })
    return {userMe}
  };

