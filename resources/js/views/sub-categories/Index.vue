<script setup>
import { useRouter } from "vue-router"
import { ref, reactive, onMounted } from  "vue"
import api, { initApi } from "../../api";
import {me} from "../../me";

const router = useRouter()
const {userMe} = me(router)

initApi(router); // Initialize the API with the router

let subCategories = ref([])
let links = ref([])
let activePage = ref(1)
let lastPage = ref(1)
let  statusArray=ref([])

const form = reactive({
    id:'',
    tb_name: '',
    status:'',
    field_name:'',

})

onMounted(async () => {
    getSubCategories()
})

const getSubCategories = async () => {
    let response = api.value.get ( `/api/auth/sub-categories?page=${activePage.value}`)
    .then((response) => {

        lastPage.value = response.data.result.last_page
        subCategories.value = response.data.result.data
        statusArray.value = response.data.result.data.map(item => item.status);
        links.value = response.data.result.links

    })
}

const changePage =(link) =>{

    if(!link.url || link.active){
        return
    }

    activePage.value = link.label

    api.value.get(link.url)
        .then((response) =>{
           subCategories.value = response.data.result.data
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
        getSubCategories(activePage.value)

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
                           getSubCategories()
                    }

                })
        }
    });
}


</script>


<template>
 <main id="main" class="main">

        <div class="pagetitle">
            <h1>Մենյուի ենթաբաժիններ</h1>
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
                                    <h5 class="card-title">Մենյուի ենթաբաժիններ</h5>
                                    <div class="pull-right d-flex justify-content-end m-3" >
                                        <router-link class="btn btn-primary  mb-2" :to="{name: 'subCategories.create'}"><i class="fa fa-plus"></i> Ստեղծել </router-link>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>Հ/Հ</th>
                                        <th>Վերնագիր</th>
                                        <th>Մենյուի բաժին</th>
                                        <th>Կարգավիճակ</th>
                                        <th width="10%">Գործողություն</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(subCategory, index) in subCategories">
                                        <td>{{ ++index }}</td>
                                        <td>{{ subCategory.title }}</td>
                                        <td>{{ subCategory.category_name }}</td>
                                        <td :style="{ color: subCategory.status == 0 ? 'red' : 'green' }">
                                            <button
                                                type="button"
                                                :class="subCategory.status == 1 ? 'btn btn-success' : 'btn btn-danger '">
                                                {{ subCategory.status == 1 ? 'Ակտիվ' : 'Պասիվ' }}
                                            </button>

                                        </td>

                                        <td>
                                            <div class="dropdown action" v-if="category.governing_body_id == userMe.governing_body_id" >
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <router-link class="dropdown-item" :to="{name: 'subCategories.edit', params: { id: subCategory.id } }">
                                                        <i class="bx bx-edit-alt me-1"></i>Խմբագրել</router-link>
                                                    <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input change_status" type="checkbox"
                                                                role="switch"
                                                                :checked="subCategory.status"
                                                                @change="changeStatus(index, $event, subCategory.id,'sub_categories','status')"
                                                            >
                                                        </div>Կարգավիճակ
                                                    </a>
                                                    <button type="button" class="dropdown-item click_delete_item" @click = "deleteItem(subCategory.id,'sub_categories')">
                                                        <i class="bx bx-trash me-1"></i>
                                                        Ջնջել</button>
                                                </div>
                                            </div>
                                            <div v-else><i class="bx bx-stop-circle me-1"></i></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- ==========links ================ -->
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
