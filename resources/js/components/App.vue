<script setup>

import {ref, onMounted, watch} from 'vue';
import {useRouter,  useRoute } from 'vue-router';
    import AdminLayout from "./AdminLayout.vue";
    import Login from "../views/auth/Login.vue";
    import ResetPasswordEmail from '../views/auth/password/Email.vue';

    const route = useRoute();
    const router = useRouter()

    const isAuthenticated = ref(false);
    onMounted(() => {

        isAuthenticated.value = !!localStorage.getItem('access_token');
    });
    watch(
    () => route.name,
    (newRoute) => {
        if (!isAuthenticated.value && newRoute === 'password.reset') {
            console.log(656412)
            // Allow unauthenticated access to reset password
            return;
        }
        if (!isAuthenticated.value) {
            console.log(1111111112)
            // Redirect unauthenticated users to login
            router.push({ name: 'login' });
        }
    }
);

</script>
<template>

    <ResetPasswordEmail v-if="route.name === 'password.reset'" />
    <AdminLayout v-if="isAuthenticated && route.name !== 'password.reset'" />
    <Login  v-if="!isAuthenticated && route.name !== 'password.reset'" />


</template>
