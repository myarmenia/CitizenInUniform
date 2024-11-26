<script setup>

import {ref, onMounted, watch} from 'vue';
import {useRouter,  useRoute } from 'vue-router';
    import AdminLayout from "./AdminLayout.vue";
    import Login from "../views/auth/Login.vue";
    import ResetPasswordEmail from '../views/auth/password/Email.vue';
    import ResetPasswordReset from '../views/auth/password/Reset.vue';

    const route = useRoute();
    const router = useRouter()

    const isAuthenticated = ref(false);
    onMounted(() => {


        isAuthenticated.value = !!localStorage.getItem('access_token');
    });
    watch(
    () => route.name,
    (newRoute) => {

        console.log(newRoute)
        if (!isAuthenticated.value && newRoute === 'password.reset') {
            console.log(656412)
            // Allow unauthenticated access to reset password
            return;
        }
        if (!isAuthenticated.value && newRoute === 'reset.password.reset') {
            console.log(33333333)
            // Allow unauthenticated access to reset password
            return;
        }

        if (!isAuthenticated.value && newRoute ==='Login') {
            console.log(1111111112)
            // Redirect unauthenticated users to login
            router.push('/login' );
        }
        if (isAuthenticated.value && newRoute ==='Login') {
            // localStorage.removeItem('access_token');

            window.location.href='/welcome'
        }

    }
);

</script>
<template>


    <ResetPasswordEmail v-if="route.name === 'password.reset'" />
    <ResetPasswordReset v-if=" !isAuthenticated && route.name === 'reset.password.reset'" />
    <AdminLayout v-if="isAuthenticated && route.name !== 'password.reset' && route.name !== 'Login'" />
    <Login  v-if="!isAuthenticated && route.name === 'Login'" />


</template>
