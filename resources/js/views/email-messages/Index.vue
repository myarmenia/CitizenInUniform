<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted, watch } from  "vue"
import api, { initApi } from "../../api";

const router = useRouter()
const route = useRoute()

initApi(router); // Initialize the API with the router

let messages = ref([])
let links = ref([])
let activePage = ref(1)
let lastPage = ref(1)
let statusArray=ref([])


const getMessages = async () => {
    try {

        const answered = route.query.answered || 0;

        const response = await api.value.get(`/api/auth/email-messages?answered=${answered}&page=${activePage.value}`);

        lastPage.value = response.data.result.last_page;
        messages.value = response.data.result.data;
        statusArray.value = response.data.result.data.map(item => item.status);
        links.value = response.data.result.links;

    } catch (error) {
        console.error("Error fetching messages:", error);
    }
};


watch(
    () => route.query.answered,
    () => {
        activePage.value = 1; // сбрасываем страницу на первую при изменении фильтра
        getMessages();
    }
);

onMounted(() => {
    getMessages();
});


const changePage =(link) =>{
    console.log(link)
    if(!link.url || link.active){
        return
    }

    activePage.value = link.label

    api.value.get(link.url)
        .then((response) =>{
           messages.value = response.data.result.data
            links.value = response.data.result.links
        })
}




</script>


<template>
 <main id="main" class="main">

        <div class="pagetitle">
            <h1>Նամակագրություն</h1>
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
                                    <h5 class="card-title">Նամակագրություն</h5>
                                    <div class="pull-right d-flex justify-content-end m-3" >
                                        <router-link class="btn btn-primary  mb-2 mx-2"
                                            :to="{name: 'email-messages.index', query: { answered: 0 } }"
                                            :class="{ 'btn-secondary': $route.query.answered == '0' || $route.query.answered == null }"> Նոր</router-link>

                                        <router-link class="btn btn-primary  mb-2"
                                            :to="{name: 'email-messages.index', query: { answered: 1 } }"
                                            :class="{ 'btn-secondary': $route.query.answered == '1' }"> Պատասխանված</router-link>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>Հ/Հ</th>
                                        <th>Հարցի տեսակը</th>
                                        <th>Անուն Ազգանուն</th>
                                        <th>Էլ․ հասցե</th>
                                        <th>Ամսաթիվ</th>
                                        <th width="10%">Գործողություն</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(message, index) in messages">
                                        <td>{{ ++index }}</td>
                                        <td>{{ message.msg_category_name }}</td>
                                        <td>{{ message.fullname }}</td>
                                        <td>{{ message.email }}</td>
                                        <td>{{ message.date }}</td>

                                        <td>
                                            <div class="dropdown action" >
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <router-link class="dropdown-item" :to="{name: 'email-messages.edit', params: { id: message.id } }">
                                                        <i class="bx bx-edit-alt me-1"></i>Դիտել</router-link>
                                                </div>
                                            </div>
                                        </td>
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
