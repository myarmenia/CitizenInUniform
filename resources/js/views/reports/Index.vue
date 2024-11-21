<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted, watch } from  "vue"
import api, { initApi } from "../../api";
import { useGoverningBodies } from "../../sidebar";


const router = useRouter()
const route = useRoute()
initApi(router); // Initialize the API with the router

let report = ref([])
let emailCategories = ref([])
const selectedCategory = ref('Նամակի կատեգորիան');
const messageType = ref('Հաղորթագրության տեսակ')
const governingBody = ref('Պետական մարմին')

const { governingBodies } = useGoverningBodies(router);

const form = reactive({
    message_category_id: '',
    message_type: '',
    governing_body_id: '',
    from_created_at: '',
    to_created_at: '',
})

const getEmailCategies = async () => {
    let response =  api.value.get ( '/api/mobile/message-categories-with-trashed')
    .then((response) => {

       emailCategories.value = response.data.result
    })
}

function handleSelectionChange(selectionKey) {
  switch (selectionKey) {
    case 'message_category':
        form.message_category_id = selectedCategory.value
        break;
    case 'message_type':
        form.message_type = messageType.value
        break;
    case 'governing_body':
        form.governing_body_id = governingBody.value
        break;
    default:
      console.error('Unknown selection:', selectionKey);
  }
}


const filterMessages = () => {
    console.log(form)
    sendRequest()
}

const cancelFilter = () => {
    form.message_category_id = ''
    form.message_type = ''
    form.governing_body_id = '',
    selectedCategory.value = 'Ընտրել հարցի կատեգորիան'
    messageType = 'Հաղորթագրության տեսակ'
    governingBody = 'Պետական մարմին'
    form.from_created_at = ''
    form.to_created_at = ''

    sendRequest()
}


const sendRequest = async () => {
    try {

        const response = await api.value.post('/api/auth/reports', form);

        lastPage.value = response.data.result.last_page;
        messages.value = response.data.result.data;
        statusArray.value = response.data.result.data.map(item => item.status);
        links.value = response.data.result.links;

    } catch (error) {
        console.error("Error fetching messages:", error);
    }
};


// watch(
//     () => form.has_answer,
//     () => {


//         sendRequest()
//     }
// );


onMounted(() => {
    getEmailCategies()
    // sendRequest()
});


</script>


<template>
 <main id="main" class="main">

        <div class="pagetitle">
            <h1>Հաշվետվություն</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item "></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div>

                                <div class="div-form d-flex row g-3 mt-2" >
                                    <div class="mb-3 d-flex justify-content-end ">

                                        <div class="col-2  mx-2">
                                            <select class="form-select"  v-model="selectedCategory"  @change="handleSelectionChange('message_category')" >
                                                <option disabled selected>Նամակի կատեգորիան </option>
                                                <option value="">Բոլորը </option>
                                                <option
                                                    v-for="category in emailCategories"
                                                    :key="category.id"
                                                    :value="category.id"
                                                    :style="{ color: category.deleted_at ? 'red' : 'black' }">
                                                    {{ category.title }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-2  mx-2">
                                            <select class="form-select"  v-model="messageType"  @change="handleSelectionChange('message_type')" >
                                                <option disabled selected>Հաղորթագրության տեսակ </option>
                                                <option value="">Բոլորը </option>
                                                <option value="email">Էլ․ փոստ </option>
                                                <option value="chat">Չատ </option>
                                            </select>
                                        </div>

                                        <div class="col-2  mx-2">
                                            <select class="form-select"  v-model="governingBody"  @change="handleSelectionChange('governing_body')" >
                                                <option disabled selected>Պետական մարմին </option>
                                                <option value="">Բոլորը </option>
                                                <option v-for="body in governingBodies" :key="body.id" :value="body.id">{{body.name}}</option>
                                            </select>
                                        </div>

                                        <div class="col-2  mx-2">
                                            <input type="date" title="Սկիզբ" class="form-control selectdate" id="datefrom" placeholder="Ստեղծման ամսաթիվ" v-model="form.from_created_at" value="" >
                                        </div>

                                        <div class="col-2  mx-2">

                                            <input type="date" title="Ավարտ" class="form-control selectdate" id="dateto" placeholder="Ստեղծման ամսաթիվ" v-model="form.to_created_at" value="" >
                                        </div>

                                    </div>
                                    <div class="mb-3 d-flex justify-content-end ">
                                        <div class="col-2 d-flex justify-content-end ">
                                            <button class="btn btn-primary search mx-2 py-1 " @click="filterMessages">Ֆիլտրացիա</button>
                                            <button class="btn btn-primary search " @click="cancelFilter">Չեղարկել</button>

                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Հ/Հ</th>
                                        <th>Նամակներ</th>
                                        <th>Չատ</th>
                                        <th>Զանգեր</th>
                                        <th>Ընդ․ ներբեռնում</th>
                                        <th>IOS ներբեռնում</th>
                                        <th>Android ներբեռնում</th>
                                        <th width="10%">Ընդամենը</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in report">
                                        <td>{{ ++index }}</td>
                                        <td>{{ item.email }}</td>
                                        <td>{{ item.chat }}</td>
                                        <td>{{ item.call }}</td>
                                        <td>{{ item.download_all }}</td>
                                        <td>{{ item.download_ios }}</td>
                                        <td>{{ item.download_android }}</td>
                                        <td>{{ item.sum }}</td>

                                    </tr>
                                </tbody>
                            </table> -->

                            <!-- End Bordered Table -->


                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

</template>
