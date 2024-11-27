
<script setup>
import { useRouter } from 'vue-router';
const router = useRouter();

const goBack = () => {
  router.go(-1);
};
</script>
<template>
    <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>404</h1>
        <h2>Նման էջ գոյություն չունի</h2>

        <img src="https://citizen.trigger.ltd/assets/img/logo.png" alt="citizenInUniform" id="logo" style="width: 100px">
        <!-- <router-link to="/">Վերադառնալ</router-link> -->
        <button type="button" class="btn mt-2" @click="goBack">Վերադառնալ նախորդ էջ</button>
      </section>

    </div>
  </main>
</template>
