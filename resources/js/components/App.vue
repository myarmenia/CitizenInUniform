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

        isAuthenticated.value = !!sessionStorage.getItem('access_token');
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


                sessionStorage.removeItem('access_token');
                window.location.href='/login'


            }
            if(newRoute ==='password.reset' || newRoute ==='reset.password.reset'){
                let  $token=sessionStorage.getItem('access_token');
                if($token){
                    sessionStorage.removeItem('access_token');
                     window.location.href='/login'
                }

            }
        }

    }
);

// ==============================


let isLogoutTriggered = false; // Флаг для предотвращения ложных срабатываний
let isReloading = true; // Флаг для отслеживания перезагрузки страницы
let chatUrl = null
function handleBeforeUnload(event) {

    const isLoginPage = window.location.pathname === '/login'; // Проверяем, страница логина или нет
    // Предотвращаем выполнение, если уже выполняется logout
    chatUrl = sessionStorage.getItem('chat_url')
    console.log('isLoginPage:', isLoginPage);
    console.log('chatUrl:', chatUrl);

    if (isLoginPage) {
        sessionStorage.removeItem('chat_url');
        return; // Ничего не делаем, если условие выполнено
    }

    if (chatUrl && chatUrl === 'chat_url'){
        return
    }

    sessionStorage.removeItem('chat_url');
    // Уведомляем пользователя о том, что вкладка закрывается
    event.preventDefault();
    event.returnValue = '';

}

function logoutUser() {
    isLogoutTriggered = true;
    // Здесь отправляем запрос на сервер для logout

    api.value.post('/api/auth/logout');
    router.push('/login')
}

function handleUnload() {

    logoutUser(); // Выполняем логаут при закрытии страницы
}

onMounted(() => {
  window.addEventListener('beforeunload', handleBeforeUnload);
  window.addEventListener('unload', handleUnload);
});

onBeforeUnmount(() => {
  window.removeEventListener('beforeunload', handleBeforeUnload);
  window.addEventListener('unload', handleUnload);
});


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

