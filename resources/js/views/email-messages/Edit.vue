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
    content: '',
    email_message_id : ''

})

onMounted(async () => {
    getMessage()
})


const getMessage = async () => {

    let response = api.value.get( `/api/auth/email-messages/${route.params.id}`)
    .then((response) => {
        console.log(888888888,response.data.result)

        let result = response.data.result
            message.value = result
            form.email_message_id = result.id

            console.log('--------- ',  message.value.msg_category['title'])

    })
}

const dataSave = async () => {
    const toastInstance = toast.fire({
        title: 'Պատասխանը ուղարկվում է',
        didOpen: () => {
            Swal.showLoading();
        },
    });
    try {
        await api.value.post('/api/auth/email-messages-answer/store', form)

        router.push('/email-messages')
        toast.fire({icon: 'success', title: 'Գործողությունը հաջողությամբ կատարված է'})

    } catch (error) {
            errors.value = error.response.data.errors
    }
    finally {
        setTimeout(() => Swal.close(), 2000);
    }
}

const isImage = (file) => {
  const imageFormats = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'];
  const fileExtension = file.name.split('.').pop().toLowerCase();
  return imageFormats.includes(fileExtension);
};

const isOther = (file) => {
  const documentFormats = ['doc', 'docx', 'xls', 'xlsx', 'txt'];
  const fileExtension = file.name.split('.').pop().toLowerCase();
  return documentFormats.includes(fileExtension);
};
const isPdf = (file) => {
  const fileExtension = file.name.split('.').pop().toLowerCase();
  return fileExtension === 'pdf';
};


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
                                        <div class="col-lg-3 col-md-4 label ">Հարցի կատեգորիա</div>
                                        <div class="col-lg-9 col-md-8" v-if="message.msg_category && message.msg_category.deleted != null">
                                            {{ message.msg_category.title }}
                                            <span class="text-danger mx-5">կատեգորիան այլևս ջնջված է</span>
                                        </div>
                                        <div class="col-lg-9 col-md-8" v-else>
                                            {{ message.msg_category ? message.msg_category.title : '' }}
                                        </div>
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
                                        <div class="col-lg-3 col-md-4 label">Հեռախոսահամար</div>
                                        <div class="col-lg-9 col-md-8">{{message.phone}}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Ամսաթիվ</div>
                                        <div class="col-lg-9 col-md-8">{{message.date}}</div>
                                    </div>
                                    <h5 class="card-title">Հաղորդագրություն</h5>
                                    <p class="small fst-italic">{{message.content}}</p>
                                    <h5 class="card-title">Կից ֆայլեր</h5>

                                    <div class="justify-content-start" v-if="message.files && message.files.length > 0">
                                        <div v-for="(file, index) in message.files" :key="index" class="mx-2">


                                                <div class="d-flex justify-content-start col-sm-9 flex-wrap" v-if="isImage(file)">

                                                    <div class="files d-flex align-items-start">
                                                        <a :href="file.path" target="_blank">
                                                            <img :src="file.path" alt="Изображение" class="image img-thumbnail mx-0 my-2" />
                                                        </a>
                                                    </div>
                                                </div>
                                                <div v-else-if="isOther(file)">
                                                        <a :href="file.path" target="_blank">
                                                            <i class="fa fa-file"></i> {{ file.name }}
                                                        </a>
                                                </div>
                                                <div v-else-if="isPdf(file)">
                                                    <a :href="file.path" target="_blank">
                                                        <i class="fa fa-file"></i> {{ file.name }}
                                                    </a>
                                                </div>


                                        </div>

                                    </div>

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
                                </div>
                            </div>

                            <hr>



                            <div class="row mb-3">
                                <label for="title" class="col-sm-3 col-form-label">Պատասխանել </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control"  v-model="form.content"></textarea>
                                    <!-- <input type="text" class="form-control" v-model="form.title" id="title"
                                        placeholder="Վերնագիր" value="form.title"> -->
                                    <div class="mb-3 row " v-if="errors.content">
                                        <p class="col-sm-10 text-danger fs-6" v-for="error in errors.content">{{ error }}
                                        </p>
                                    </div>
                                </div>
                            </div>



                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" @click="dataSave">Ուղարկել</button>
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
