<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted, watch } from  "vue"
import api, { initApi } from "../../api";
import { state } from '../../reactive-state';

const router = useRouter()
const route = useRoute()
const selectedCategory = ref('Ընտրել հարցի կատեգորիան');
initApi(router); // Initialize the API with the router

console.log(state.emailMessageCount, 555)
let messages = ref([])
let links = ref([])
let activePage = ref(1)
let lastPage = ref(1)
let statusArray=ref([])
let emailCategories = ref([])



const form = reactive({
    has_answer: 0,
    message_category_id: '',
    searchText: '',
    from_created_at: '',
    to_created_at: '',
    action: null
})


const getEmailCategies = async () => {
    let response =  api.value.get ( '/api/mobile/message-categories')
    .then((response) => {

       emailCategories.value = response.data.result
    })
}

const handleSelectionChange = () => {
    form.message_category_id = selectedCategory.value

}

const changeTypeMessages = (has_answer) =>{

    form.has_answer = has_answer
    sendRequest()
}



const serachMessages = async () => {

    form.action = 'search_text'
    form.message_category_id = ''
    selectedCategory.value = 'Ընտրել հարցի կատեգորիան',
    form.from_created_at = '',
    form.to_created_at = '',
    sendRequest()

};

const filterMessages = () => {
    form.action = 'filter'
    form.searchText = '',
    sendRequest()
}

const cancelFilter = () => {
    form.action = null
    form.message_category_id = ''
    selectedCategory.value = 'Ընտրել հարցի կատեգորիան',
    form.from_created_at = '',
    form.to_created_at = '',
    form.searchText = ''
    sendRequest()
}


const sendRequest = async () => {
    try {

        activePage.value = 1
        const response = await api.value.post(`/api/auth/email-messages?page=${activePage.value}`, form);

        lastPage.value = response.data.result.last_page;
        messages.value = response.data.result.data;
        statusArray.value = response.data.result.data.map(item => item.status);
        links.value = response.data.result.links;

    } catch (error) {
        console.error("Error fetching messages:", error);
    }
};


watch(
    () => form.has_answer,
    () => {

        activePage.value = 1; // сбрасываем страницу на первую при изменении фильтра

        sendRequest()
    }
);

watch(
    () => state.emailMessageCount,
    (newCount) => {
        sendRequest(newCount); // Вызываем функцию при изменении
    }
);


onMounted(() => {
    getEmailCategies()
    sendRequest()
});


const changePage =(link) =>{

    if(!link.url || link.active){
        return
    }

    activePage.value = link.label

    api.value.post(link.url, form)
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
                                    <div class="pull-right d-flex justify-content-end my-3" >
                                        <!-- <router-link class="btn btn-primary  mb-2 mx-2"
                                            :to="{name: 'email-messages.index', query: { has_answer: 0 } }"
                                            :class="{ 'btn-secondary': $route.query.has_answer == '0' || $route.query.has_answer == null }"> Նոր</router-link>

                                        <router-link class="btn btn-primary  mb-2"
                                            :to="{name: 'email-messages.index', query: { has_answer: 1 } }"
                                            :class="{ 'btn-secondary': $route.query.has_answer == '1' }"> Պատասխանված</router-link> -->
                                            <button
                                                class="btn btn-primary mb-2 mx-2"
                                                :class="{ 'btn-secondary': form.has_answer == '0' || form.has_answer == null }"
                                                @click="changeTypeMessages(0)">
                                                Նոր
                                            </button>
                                            <button
                                                class="btn btn-primary mb-2 mx-2"
                                                :class="{ 'btn-secondary': form.has_answer == '1'}"
                                                @click="changeTypeMessages(1)">
                                                Պատասխանված
                                            </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="div-form d-flex row g-3 mt-2">
                                    <div class="mb-3 d-flex justify-content-end ">
                                        <div class="col-6">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" v-model="form.searchText" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" @keydown.enter="serachMessages">
                                                <span class="input-group-text" id="basic-addon2" @click="serachMessages"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="div-form d-flex row g-3 mt-2" >
                                    <div class="mb-3 d-flex justify-content-end ">

                                        <div class="col-2  mx-2">
                                            <select class="form-select"  v-model="selectedCategory"  @change="handleSelectionChange" >
                                                <option disabled selected>Ընտրել հարցի կատեգորիան </option>
                                                <option v-for="category in emailCategories" :key="category.id" :value="category.id">{{category.title}}</option>
                                            </select>
                                        </div>

                                        <div class="col-2  mx-2">
                                            <input type="date" title="Սկիզբ" class="form-control selectdate" id="datefrom" placeholder="Ստեղծման ամսաթիվ" v-model="form.from_created_at" value="" >
                                        </div>

                                        <div class="col-2  mx-2">

                                            <input type="date" title="Ավարտ" class="form-control selectdate" id="dateto" placeholder="Ստեղծման ամսաթիվ" v-model="form.to_created_at" value="" >
                                        </div>

                                        <div class=" d-flex justify-content-end ">
                                            <button class="btn btn-primary search mx-2 py-1 " @click="filterMessages">Ֆիլտրացիա</button>
                                            <button class="btn btn-primary search " @click="cancelFilter">Չեղարկել</button>

                                        </div>

                                    </div>
                                </div>


                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>Հ/Հ</th>
                                        <th>Հարցի կատեգորիա</th>
                                        <th>Անուն Ազգանուն</th>
                                        <th>Էլ․ հասցե</th>
                                        <th>Հեռախոսահամար</th>
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
                                        <td>{{ message.phone }}</td>
                                        <td>{{ message.date }}</td>

                                        <td>
                                            <router-link class="" :to="{name: 'email-messages.edit', params: { id: message.id } }">
                                                <i class="bx bx-edit-alt me-1"></i>Դիտել</router-link>
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
