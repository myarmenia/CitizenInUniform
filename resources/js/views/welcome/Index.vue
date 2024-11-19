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
                                <h3 >Համազգեստով քաղաքացի</h3>
                            </div>
                            <h5 class="card-title">Բարիգալուստ {{userMe.name}} {{userMe.surname}}</h5>
                        </div>
                    </div><!-- End Default Card -->
                </div>
            </div>
        </section>
    </main>
</template>
