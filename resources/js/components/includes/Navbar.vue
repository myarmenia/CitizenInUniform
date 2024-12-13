<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useRouter } from 'vue-router';
import api, { initApi } from "../../api";
import {me} from "../../me";
import LoginHistoryModal from './LoginHistoryModal.vue';
import {logoutFunction} from '../../logout';
import { computed } from 'vue';
const router = useRouter();
const {userMe} = me(router)
console.log(userMe)
const {logout} = logoutFunction(router)

initApi(router);
const errorMessage = ref(false);



const clickBurger = () => {
    const body = document.body;
    body.classList.toggle('toggle-sidebar');
}
const modalData = ref([]);




const openModal = async () => {

    try {
        let response = await api.value.get('/api/auth/user-login-logs');
        modalData.value = response.data.result

    } catch (error) {
        errorMessage.value = error
    }
};



// Computed property to format roles
const formattedRoles = computed(() =>
  userMe.value.rolesWithTranslations ?
    userMe.value.rolesWithTranslations.map(role => role.translation).join(', ') : ''
);




</script>

<template>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <router-link  class="logo d-flex align-items-center " :to="{name: 'welcome.index'}">
                <img src="../../../../public/assets/img/logo.png" alt="">
            </router-link>
            <i class="bi bi-list toggle-sidebar-btn" @click="clickBurger"></i>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

                        <i class="ri-account-circle-line d-block d-lg-none"  style="font-size: 30px"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2 ">
                            {{userMe.name}} {{userMe.surname}}
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                        <h6>{{userMe.name}} {{userMe.surname}}</h6>
<!-- show auth user roles -->
                        <span>
                            {{ formattedRoles }}
                        </span>

                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                data-bs-toggle="modal"
                                data-bs-target="#loginhHistory"
                                @click="openModal"
                                >
                                <i class="bi bi-person"></i>
                                <span>Մուտքերի պատմություն</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                        <router-link class="dropdown-item d-flex align-items-center" :to="{name:'change-password.index'}">
                            <i class="bi bi-gear"></i>
                            <span>Գաղտնաբառի փոփոխություն</span>
                        </router-link>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center"
                                    @click.prevent="logout"
                                    >
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Ելք</span>
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <LoginHistoryModal :data="modalData"  />

</template>
<!-- ========= -->
