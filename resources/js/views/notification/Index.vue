<script setup>
import { useRouter } from "vue-router"
import { ref, reactive, onMounted } from  "vue"
import api, { initApi } from "../../api";
import {me} from "../../me";

const router = useRouter()
const {userMe} = me(router)
initApi(router);

let notifications = ref([])
let links = ref([])
let activePage = ref(1)
let lastPage = ref(1)

const form = reactive({
    setting_id:'',
    title: '',
    content:'',

})

onMounted(async () => {
    getNotifications()
})

const getNotifications = async () => {

    let response = api.value.get ( `/api/auth/notifications?page=${activePage.value}`)
    .then((response) => {

        lastPage.value = response.data.result.last_page
        notifications.value = response.data.result.data

        links.value = response.data.result.links

    })
}

const changePage =(link) =>{
    console.log(link)
    if(!link.url || link.active){
        return
    }

    activePage.value = link.label

    api.value.get(link.url)
        .then((response) =>{
           notifications.value = response.data.result.data
            links.value = response.data.result.links
        })
}

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return format(date, 'dd MMMM yyyy');
};


</script>


<template>
 <main id="main" class="main">

        <div class="pagetitle">
            <h1>Ծանուցումներ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">Ցանկ</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="pull-left">
                                <div class = "d-flex justify-content-between">
                                    <h5 class="card-title">Ծանուցումներ</h5>
                                    <div class="pull-right d-flex justify-content-end m-3" v-if="userMe.roles?.some(role =>role.name === 'adminMIP' ||  role.name === 'adminPN'  )"  >
                                        <router-link class="btn btn-primary  mb-2" :to="{name: 'notifications.create'}"><i class="fa fa-plus"></i> Ստեղծել</router-link>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Հ/Հ</th>
                                        <th>Տեսակ</th>
                                        <th>Վերնագիր</th>
                                        <th>Բովանդակություն</th>
                                        <th>Ամսաթիվ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(notify, index) in notifications">
                                        <td>{{ ++index }}</td>
                                        <td>{{ notify.setting.name }}</td>
                                        <td>{{ notify.title }}</td>
                                        <td>{{ notify.content }}</td>
                                        <td>{{ notify.created_at }}</td>

                                    </tr>
                                </tbody>
                            </table>
                            <!-- End Bordered Table -->

                            <nav aria-label="" v-if="lastPage > 1" class="d-flex justify-content-end">
                                <ul class="pagination">
                                    <li class="page-item "
                                        v-for="(link,index) in links"
                                        :key="index"
                                        :class="{active: link.active,disabled:!link.url }"
                                        @click="changePage(link)"
                                    >
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true" v-html="link.label"></a>
                                    </li>

                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

</template>
