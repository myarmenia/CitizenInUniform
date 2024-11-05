<script setup>

import {ref, onMounted} from 'vue';
    import AdminLayout from "./AdminLayout.vue";
    import Login from "../views/auth/Login.vue";

    const isAuthenticated = ref(false);
    onMounted(() => {
        console.log(!!localStorage.getItem('access_token'))
        isAuthenticated.value = !!localStorage.getItem('access_token');
    });

</script>
<template>

    <AdminLayout v-if="isAuthenticated" />
    <Login v-else  />


</template>
