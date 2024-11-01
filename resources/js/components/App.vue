<script setup>

import {ref, onMounted} from 'vue';
    import AdminLayout from "./AdminLayout.vue";
    import Login from "../views/auth/Login.vue";

    const isAuthenticated = ref(false);
    onMounted(() => {
        isAuthenticated.value = !!localStorage.getItem('access_token'); // `auth` token indicates login status
    });

</script>
<template>

    <!-- <AdminLayout v-if="localStorage.getItem('auth')" /> -->
    <Login  />


</template>
