<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted, watch } from  "vue"
import api, { initApi } from "../../api";


const router = useRouter()
const route = useRoute()
initApi(router); // Initialize the API with the router

let logs = ref([])
let links = ref([])
let activePage = ref(1)
let lastPage = ref(1)
let roles = ref([])
const selectedRole = ref('Դերեր');
const actionType = ref('Գործողության տեսակ')
const messageType = ref('Հաղորդագրության տեսակ')

const form = reactive({
    action: '',
    roles: '',
    tb_name: '',
    from_created_at: '',
    to_created_at: '',
})

const getRoles = async () => {
    let response =  api.value.get ( '/api/auth/all-roles-list')
    .then((response) => {

       roles.value = response.data.roles
    })
}

const changePage =(link) =>{

    if(!link.url || link.active){
        return
    }

    activePage.value = link.label

    api.value.post(link.url, form)
        .then((response) =>{
            console.log(response.data.result)
            logs.value = response.data.result.data
            links.value = response.data.result.links
        })
}



function handleSelectionChange(selectionKey) {
  switch (selectionKey) {
    case 'message_type':
        form.tb_name = messageType.value
        break;
    case 'action_type':
        form.action = actionType.value
        break;
    case 'roles':
        form.roles = selectedRole.value
        break;
    default:
      console.error('Unknown selection:', selectionKey);
  }
}


const filterMessages = () => {

    sendRequest()
}

const cancelFilter = () => {

    actionType.value = 'Գործողության տեսակ'
    messageType.value = 'Հաղորդագրության տեսակ'
    selectedRole.value = 'Դերեր'
    form.action = ''
    form.roles = ''
    form. tb_name = ''
    form.from_created_at = ''
    form.to_created_at = ''

    sendRequest()
}


const sendRequest = async () => {
    try {

        activePage.value = 1
        const response = await api.value.post(`/api/auth/logs?page=${activePage.value}`, form);

        let result = response.data.result
            // console.log(result, 'dddddddddddd')
            lastPage.value = result.last_page
            logs.value = result.data
            links.value = result.links


    } catch (error) {
        console.error("Error fetching messages:", error);
    }
};



onMounted(() => {
    getRoles()
    sendRequest()
});


</script>


<template>
 <main id="main" class="main">

        <div class="pagetitle">
            <h1>Լոգավորում</h1>
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
                                            <select class="form-select"  v-model="selectedRole"  @change="handleSelectionChange('roles')" >
                                                <option disabled selected>Դերեր</option>
                                                <option value="">Բոլորը </option>
                                                <option
                                                    v-for="(role, index) in roles"
                                                    :key="index"
                                                    :value="index">
                                                    {{ role }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-2  mx-2">
                                            <select class="form-select"  v-model="actionType"  @change="handleSelectionChange('action_type')" >
                                                <option disabled selected>Գործողության տեսակ</option>
                                                <option value="">Բոլորը </option>
                                                <option value="created">Ստեղծված </option>
                                                <option value="updated">Փոփոխված </option>
                                                <option value="deleted">Ջնջված </option>
                                            </select>
                                        </div>

                                        <div class="col-2  mx-2">
                                            <select class="form-select"  v-model="messageType"  @change="handleSelectionChange('message_type')" >
                                                <option disabled selected>Հաղորդագրության տեսակ </option>
                                                <option value="">Բոլորը </option>
                                                <option value="email_message_answers">Նամակագրություն </option>
                                                <option value="messages">Չատ </option>
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
                                        <th>Հ/Հ</th>
                                        <th>Անուն ազգանուն</th>
                                        <th>Դեր</th>
                                        <th>Գործողության</th>
                                        <th>Բաժին</th>
                                        <th>IP</th>
                                        <th>Տվյալներ</th>
                                        <th>Ամսաթիվ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(log, index) in logs">
                                        <td>{{ ++index }}</td>
                                        <td>{{ log.user_name }}</td>
                                        <td>{{ log.roles }}</td>
                                        <td>{{ log.action }}</td>
                                        <td>{{ log.tb_name }}</td>
                                        <td>{{ log.ip }}</td>
                                        <td>{{ log.details }}</td>
                                        <td>{{ log.date }}</td>

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
