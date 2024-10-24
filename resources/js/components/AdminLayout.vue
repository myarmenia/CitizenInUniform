<script setup>
    import Sidebar from "./includes/Sidebar.vue";
    import Navbar from "./includes/Navbar.vue";
</script>
<template>
    <Navbar />
    <Sidebar />
    <router-view/>
</template>
