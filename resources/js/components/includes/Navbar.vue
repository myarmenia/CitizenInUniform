<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useRouter } from 'vue-router';
import api, { initApi } from "../../api";
import {me} from "../../me";
const router = useRouter();
const {userMe} = me(router)

initApi(router);
const errorMessage = ref(false);

const logout = async () => {
  try {
    await api.value.post('/api/auth/logout');
    localStorage.removeItem('access_token');
      window.location.href = '/login';
  } catch (error) {
    errorMessage.value = error
  }
};







</script>

<template>

<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="index.html" class="logo d-flex align-items-center">
    <img src="../../../../public/assets/img/logo.png" alt="">

  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->


<!-- End Search Bar -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->


    <!-- End Notification Nav -->


    <!-- End Messages Nav -->




    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <!-- <img src="https://entrysystem.trigger.ltd/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
        <span class="d-none d-md-block dropdown-toggle ps-2">
            {{userMe.name}} {{userMe.surname}}
        </span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6>{{userMe.name}} {{userMe.surname}}</h6>
          <span v-for="role in userMe.roles" :key="role.id">
            <!-- {{role.name}} -->
            {{ role.name=="admin" ? "Ադմինիստրատոր":(role.name=="content_manager" ? "Բովանդակության կառավարիչ":(role.name=="operatorMIP" ? "Օպերատոր /ՄԻՊ/":(role.name=="operatorPN" ? "Օպերատոր /ՊՆ/" : (role.name=="super_admin" ? "Գլխավոր ադմինիստրատոր": null))))}}

          </span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <!-- <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li> -->

        <li>
          <router-link class="dropdown-item d-flex align-items-center" :to="{name:'change-password.index'}">
            <i class="bi bi-gear"></i>
            <span>Գաղտնաբառի փոփոխություն</span>
          </router-link>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <!-- <li>
          <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span>Need Help?</span>
          </a>
        </li> -->
        <!-- <li>
          <hr class="dropdown-divider">
        </li> -->

        <li>

            <button class="dropdown-item d-flex align-items-center"  @click.prevent="logout">
                             <i class="bi bi-box-arrow-right"></i>
                <span>Ելք</span>
            </button>


        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->


  </ul>
</nav><!-- End Icons Navigation -->

</header>

</template>
