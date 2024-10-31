<script setup>
    import Sidebar from "./includes/Sidebar.vue";
    import Navbar from "./includes/Navbar.vue";
    import ModalDelete from "./includes/ModalDelete.vue";
</script>
<template>
    <Navbar />
    <Sidebar />
    <router-view/>
    <ModalDelete/>

</template>
