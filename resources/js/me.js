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

        console.log(result)
        if(result.message!='') {
            toast.fire({icon:"error",title:result.message,
                showCloseButton: true,
                timer: 7000,
                timerProgressBar: true,

            } )

        }


        } catch (error) {
        errorMessage.value = error

        }
    }

    onMounted( async () =>{
        me()

    })
    return {userMe}
  };

