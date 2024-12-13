<script setup>

import {ref, onMounted,onUnmounted, onBeforeUnmount,watch} from 'vue';
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

// ==============================



// let isLogoutTriggered = false; // Ð¤Ð»Ð°Ð³ Ð´Ð»Ñ Ð¿Ñ€ÐµÐ´Ð¾Ñ‚Ð²Ñ€Ð°Ñ‰ÐµÐ½Ð¸Ñ Ð»Ð¾Ð¶Ð½Ñ‹Ñ… ÑÑ€Ð°Ð±Ð°Ñ‚Ñ‹Ð²Ð°Ð½Ð¸Ð¹
// let isReloading = true; // Ð¤Ð»Ð°Ð³ Ð´Ð»Ñ Ð¾Ñ‚ÑÐ»ÐµÐ¶Ð¸Ð²Ð°Ð½Ð¸Ñ Ð¿ÐµÑ€ÐµÐ·Ð°Ð³Ñ€ÑƒÐ·ÐºÐ¸ ÑÑ‚Ñ€Ð°Ð½Ð¸Ñ†Ñ‹
// let chatUrl = null

// function handleBeforeUnload(event) {

//     const isLoginPage = window.location.pathname === '/login';

//     chatUrl = sessionStorage.getItem('chat_url')
//     console.log('isLoginPage:', isLoginPage);
//     console.log('chatUrl:', chatUrl);

//     if (isLoginPage  === '/login' ||  isLoginPage === '/email-messages' || isLogoutTriggered){
//         return
//     }


//     // Если происходит перезагрузка страницы, не показываем alert
//     if (isReloading) return;

//     if (chatUrl && chatUrl === 'chat_url'){
//         isReloading = true;
//         return
//     }

//     sessionStorage.removeItem('chat_url');

//     event.preventDefault();
//     event.returnValue = '';

// }

// function logoutUser() {
//     isLogoutTriggered = true;


//     api.value.post('/api/auth/logout');
//     router.push('/login')
// }

// function handleUnload() {
// if (!isReloading) {
//     logoutUser();
//   }

// }

// window.addEventListener('beforeunload', () => {
//   const navEntries = performance.getEntriesByType('navigation');
//   if (navEntries.length > 0) {
//     const navigationType = navEntries[0].type;
//     isReloading = navigationType === 'reload'; // Проверяем, была ли это перезагрузка
//   } else {
//     isReloading = false; // Если навигация недоступна, считаем, что это не перезагрузка
//   }
// });

// onMounted(() => {
//   window.addEventListener('beforeunload', handleBeforeUnload);
//   window.addEventListener('unload', handleUnload);
// });

// onBeforeUnmount(() => {
//   window.removeEventListener('beforeunload', handleBeforeUnload);
//   window.addEventListener('unload', handleUnload);
// });


// =================================

</script>
<template>
<div class="" >{{ p }}</div>
    <!-- <NotFound v-if=" route.name === 'password.reset'" /> -->
    <ResetPasswordEmail v-if="!isAuthenticated && route.name === 'password.reset'" />
    <ResetPasswordReset v-if="!isAuthenticated && route.name === 'reset.password.reset'" />
    <AdminLayout v-if="isAuthenticated && route.name !== 'password.reset' && route.name !== 'Login'" />
     <Login  v-if="!isAuthenticated && route.name === 'Login'" />
</template>

