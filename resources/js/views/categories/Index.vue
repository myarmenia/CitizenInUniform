<script setup>
import { useRouter } from "vue-router"
import { ref, reactive, onMounted } from  "vue"
import api, { initApi } from "../../api";
import {me} from "../../me";

const router = useRouter()
const {userMe} = me(router)

initApi(router); // Initialize the API with the router

let categories = ref([])
let links = ref([])
let activePage = ref(1)
let lastPage = ref(1)
let statusArray=ref([])


const form = reactive({
    id:'',
    tb_name: '',
    status:'',
    field_name:'',

})

onMounted(async () => {
    getCategories()
})

const getCategories = async () => {

    let response = api.value.get ( `/api/auth/categories?page=${activePage.value}`)
    .then((response) => {

        lastPage.value = response.data.result.last_page
        categories.value = response.data.result.data
        statusArray.value = response.data.result.data.map(item => item.status);

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
           categories.value = response.data.result.data
            links.value = response.data.result.links
        })
}


const changeStatus = (index, event, id, tb_name, field_name) => {

    let changedStatus = event.target.checked
    statusArray.value[index] = changedStatus; // Update the checked state for the specific checkbox

    form.id = id
    form.tb_name = tb_name
    form.status = changedStatus
    form.field_name = field_name

    api.value.post('/api/auth/change-status',form)
    .then((response)=>{
        getCategories(activePage.value)

        toast.fire({icon:"success",title:"Գործողությունը հաջողությամբ կատարված է"})
    })


};

const deleteItem = (id, tb_name) =>{
    const newUrl  = `/api/auth/delete-item/${tb_name}/${id}`

    Swal.fire({
        title: "Դուք համոզված եք?",
        // text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText:"Ոչ" ,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Այո"
    })
    .then((result) => {
        if (result.isConfirmed) {
            api.value.get(newUrl)
                .then((response)=>{
                    if(response.data.result==1){

                        Swal.fire({
                        // title: "Ջնջված է",
                        text: "Ձեր գրառումը բարեհաջող ջնջվել է",
                        // icon: "success",
                        confirmButtonText: "Լավ",
                        //   // dont work css
                            customClass: {
                                icon: 'small-icon'  // Add custom class for the icon
                            }
                        });
                           getCategories()
                    }

                })
        }
    });
}
</script>


<template>
 <main id="main" class="main">

        <div class="pagetitle">
            <h1>Մենյուի բաժիններ</h1>
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
                                    <h5 class="card-title">Մենյուի բաժիններ</h5>
                                    <div class="pull-right d-flex justify-content-end m-3"  v-if="userMe.roles?.some(role =>role.name === 'adminMIP' ||  role.name === 'adminPN'  )" >
                                        <router-link class="btn btn-primary  mb-2" to="/categories/create"><i class="fa fa-plus"></i> Ստեղծել</router-link>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>Հ/Հ</th>
                                        <th>Վերնագիր</th>
                                        <th>Կարգավիճակ</th>
                                        <th width="10%">Գործողություն</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(category, index) in categories">
                                        <td>{{ ++index }}</td>
                                        <td>{{ category.title }}</td>
                                        <td :style="{ color: category.status == 0 ? 'red' : 'green' }">
                                                <button
                                                    type="button"
                                                    :class="category.status == 1 ? 'btn btn-success' : 'btn btn-danger '">
                                                    {{ category.status == 1 ? 'Ակտիվ' : 'Պասիվ' }}
                                                </button>

                                            </td>
                                        <td>

                                            <div  v-if="(userMe.governing_body_id == 2 && category.id == 1 ) || (userMe.governing_body_id == 1 && category.id == 2 )"><i class="bx bx-stop-circle me-1"></i></div>

                                            <div class="dropdown action" v-else>
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <router-link class="dropdown-item" :to="{name: 'categories.edit', params: { id: category.id } }">
                                                        <i class="bx bx-edit-alt me-1"></i>Խմբագրել </router-link>
                                                    <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input change_status" type="checkbox"
                                                                role="switch"
                                                                :checked="category.status"
                                                                @change="changeStatus(index, $event, category.id,'categories','status')"
                                                            >
                                                        </div>Կարգավիճակ
                                                    </a>

                                                    <button type="button" class="dropdown-item click_delete_item" @click = "deleteItem(category.id,'categories')" v-if="(category.id !== 1 && category.id !== 2 )"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Ջնջել</button>
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
