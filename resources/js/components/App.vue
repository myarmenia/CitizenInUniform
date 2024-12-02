<script setup>

import {ref, onMounted,onUnmounted, watch} from 'vue';
import {useRouter,  useRoute } from 'vue-router';
    import AdminLayout from "./AdminLayout.vue";
    import Login from "../views/auth/Login.vue";
    import ResetPasswordEmail from '../views/auth/password/Email.vue';
    import ResetPasswordReset from '../views/auth/password/Reset.vue';
    import NotFound from './notFound.vue';
    import api, { initApi } from "../api";
    import {logoutFunction} from '../logout';



    const route = useRoute();
    const router = useRouter()
    initApi(router);
    const isAuthenticated = ref(false);
    const {logout} = logoutFunction(router)


    onMounted(() => {

        isAuthenticated.value = !!localStorage.getItem('access_token');
    });




    watch(
    () => route.name,
    (newRoute) => {

        if(!isAuthenticated.value){

            if(newRoute == 'password.reset' ){

               return
            }else if(newRoute == 'reset.password.reset'){
                return;
            }else{



                router.push('/login')

            }
        }

        if(isAuthenticated.value){
            if(newRoute =='Login'){

                //  {{ logout }} //chi ashxatum heto najel


                localStorage.removeItem('access_token');
                window.location.href='/login'


            }
            if(newRoute ==='password.reset' || newRoute ==='reset.password.reset'){
                let  $token=localStorage.getItem('access_token');
                if($token){
                    localStorage.removeItem('access_token');
                     window.location.href='/login'
                }

            }
        }

    }
);

</script>
<template>

    <!-- <NotFound v-if=" route.name === 'password.reset'" /> -->
    <ResetPasswordEmail v-if="!isAuthenticated && route.name === 'password.reset'" />
    <ResetPasswordReset v-if="!isAuthenticated && route.name === 'reset.password.reset'" />
    <AdminLayout v-if="isAuthenticated && route.name !== 'password.reset' && route.name !== 'Login'" />
     <Login  v-if="!isAuthenticated && route.name === 'Login'" />
</template>
