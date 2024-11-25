<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted, watch } from  "vue"
import api, { initApi } from "../../api";
import { useGoverningBodies } from "../../sidebar";


const router = useRouter()
const route = useRoute()
initApi(router); // Initialize the API with the router

let report = ref([])
let allMessage = ref('-')
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

    sendRequest()
}

const cancelFilter = () => {
    form.message_category_id = ''
    form.message_type = ''
    form.governing_body_id = '',
    selectedCategory.value = 'Նամակի կատեգորիան'
    messageType.value = 'Հաղորթագրության տեսակ'
    governingBody.value = 'Պետական մարմին'
    form.from_created_at = ''
    form.to_created_at = ''

    sendRequest()
}


const sendRequest = async () => {
    try {

        const response = await api.value.post('/api/auth/reports', form);
        let result = response.data.result
        console.log(result)
            report.value = result
            allMessage.value = (!isNaN(result.message_count) ? result.message_count : 0) +
            (!isNaN(result.chat_count) ? result.chat_count : 0) +
            (!isNaN(result.call_count) ? result.call_count : 0)


    } catch (error) {
        console.error("Error fetching messages:", error);
    }
};



onMounted(() => {
    getEmailCategies()
    sendRequest()
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Նամակներ</th>
                                        <th>Չատ</th>
                                        <th>Զանգեր</th>
                                        <th>IOS ներբեռնում</th>
                                        <th>Android ներբեռնում</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr >
                                        <td>{{ report.message_count }}</td>
                                        <td>{{ report.chat_count }}</td>
                                        <td>{{ report.call_count }}</td>
                                        <td>{{ report.ios_download_count }}</td>
                                        <td>{{ report.android_download_count }}</td>
                                    </tr>
                                    <tr >
                                        <td colspan="3"> Ընդամենը <span class="fw-bold mx-2">{{allMessage}} </span></td>

                                        <td colspan="2">Ընդամենը <span class="fw-bold mx-2">{{ report.all_download_count }} </span></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- End Bordered Table -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

</template>
