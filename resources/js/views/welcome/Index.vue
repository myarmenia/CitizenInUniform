<script setup>
import { useRouter } from 'vue-router';
import api, { initApi } from "../../api";
import {me} from "../../me";

const router = useRouter();
const {userMe} = me(router)

initApi(router);

</script>
<template>
    <main id="main" class="main">
        <section class="section">
            <div class="row align-items-top">
                <div class="col-lg-12">
                    <!-- Default Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <img src="../../../../public/assets/img/logo.png" alt="log" id="logo" style="width: 120px;">
                                <h6>Համազգեստով քաղաքացի</h6>
                            </div>
                            <h5 class="card-title text-center">Բարի գալուստ {{userMe.name}} {{userMe.surname}}</h5>
                        </div>
                    </div><!-- End Default Card -->
                </div>
            </div>
        </section>



    </main>
</template>
