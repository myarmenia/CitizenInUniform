<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted } from  "vue"
import api, { initApi } from "../../api";

const router = useRouter()
const route = useRoute()
initApi(router);

let message = ref([])
let errors = ref([])

const form = reactive({
    title: '',
    file: '',
    dataFile: '',
    responseFile: '',
})

onMounted(async () => {
    getMessage()
})


const getMessage = async () => {
    let response = api.value.get( `/api/auth/email-messages/${route.params.id}`)
    .then((response) => {
        console.log(response.data.result)
        message.value = response.data.result
    //    form.title = response.data.result.title
    //    form.file = response.data.result.path

    })
}



</script>


<template>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Նամակագրություն</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">
                        <router-link class="dropdown-item" :to="{name: 'email-messages.index' }"> Ցանկ</router-link>
                    </li>
                    <li class="breadcrumb-item active">Դիտել</li>
                </ol>
            </nav>
        </div>
        <section class="section profile">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Հաղորդագրության տվյալներ </h5>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">

                                    <!-- <h5 class="card-title">Հաղորդագրության տվյալներ</h5> -->

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Հարցի տեսակը</div>
                                        <div class="col-lg-9 col-md-8">{{message.msg_category_name}}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Անուն Ազգանուն</div>
                                        <div class="col-lg-9 col-md-8">{{message.fullname}}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Էլ․ հասցե</div>
                                        <div class="col-lg-9 col-md-8">{{message.email}}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Ամսաթիվ</div>
                                        <div class="col-lg-9 col-md-8">{{message.date}}</div>
                                    </div>
                                    <h5 class="card-title">Հաղորդագրություն</h5>
                                    <p class="small fst-italic">{{message.content}}</p>

                                </div>
                            </div>



                            <div class="tab-content pt-2" v-if="message?.answers?.length">
                                <hr>
                                <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">

                                    <h5 class="card-title">Նախորդ պատասխաններ</h5>

                                    <div class="row mt-2" v-if="message?.answers?.length" v-for="answer in message.answers">
                                        <div class="col-lg-3 col-md-4 label">{{answer.date}} </div>
                                        <div class="col-lg-9 col-md-8 fst-italic">{{answer.content}}</div>
                                        <div class="col-lg-12 label mt-2 text-end">{{ answer.user_name }}</div>

                                    </div>

                                    <p class="small fst-italic">{{message.content}}</p>

                                </div>
                            </div>

                            <hr>



                            <div class="row mb-3">
                                <label for="title" class="col-sm-3 col-form-label">Պատասխանել </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control"  v-model="form.content"></textarea>
                                    <!-- <input type="text" class="form-control" v-model="form.title" id="title"
                                        placeholder="Վերնագիր" value="form.title"> -->
                                    <div class="mb-3 row " v-if="errors.title">
                                        <p class="col-sm-10 text-danger fs-6" v-for="error in errors.title">{{ error }}
                                        </p>
                                    </div>
                                </div>
                            </div>



                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" @click="categoryEdit">Ուղարկել</button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

</template>
<style scoped>

.image,
.video {
  max-width: 100px;
  max-height: 100px;
  margin-right: 10px;
}

.deleteFile{
    cursor: pointer;
}

</style>
