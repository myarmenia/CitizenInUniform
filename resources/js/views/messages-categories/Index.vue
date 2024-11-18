<script setup>
import { reactive,ref, onMounted, watch } from "vue"
import { useRouter } from "vue-router"
import axios from "axios";
import api, { initApi } from "../../api";


const router = useRouter()
initApi(router);

let allData = ref([]);
let links = ref([]);
let  faqArray=ref([])
let activePage = ref(1)
let lastPage = ref(1)



onMounted(async () =>{

    getAllData()
})
const getAllData = async () => {
    try{


        let response = await api.value.get(`api/auth/messages-categories?page=${activePage.value}`,

        )
            .then((response)=>{
                let result=response.data.result
                allData.value = result.data
                links.value = result.links
                lastPage.value = result.last_page
                faqArray.value = result.data.map(item => item.status);


            })
        }catch(error){

            console.error("Error fetching", error);

        }

}
watch(activePage, (newPage) => {
    getAllData(); // Fetch categories whenever the active page changes
});



const changePage =(link) =>{
    console.log(link,"")

    if(!link.url || link.active){
        return
    }
    activePage.value = link.label
    api.value.get(link.url)
        .then((response) =>{
            allData.value = response.data.result.data
           links.value =  response.data.result.links

        })
}


    // ===============delete section==============
    const deleteItem = (id,tb_name) =>{

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
                            getAllData()

                        }

                    })
            }
        });
    }
// ========
const form = reactive({
    id:'',
    tb_name: '',
    status:'',
    field_name:'',

})


const changeStatus = (index, event, id, tb_name, field_name) => {

    let changedStatus = event.target.checked
    faqArray.value[index] = changedStatus; // Update the checked state for the specific checkbox

    form.id = id
    form.tb_name = tb_name
    form.status = changedStatus
    form.field_name = field_name

    api.value.post('/api/auth/change-status',form)
    .then((response)=>{
        getFaqCategories(activePage.value)

        toast.fire({icon:"success",title:"Գործողությունը հաջողությամբ կատարված է"})
    })


};


</script>
<template>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Նամակագրության կատեգորիաներ</h1>
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
                                    <h5 class="card-title">
                                        <!-- ՀՏՀ կատեգորիա -->
                                    </h5>
                                    <div class="pull-right d-flex justify-content-end m-3" >
                                        <router-link class="btn btn-primary  mb-2" :to="{name:'messages-categories.create'}"><i class="fa fa-plus"></i> Ստեղծել</router-link>
                                    </div>
                                </div>
                            </div>


                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Հ/Հ</th>
                                        <th>Նամակագրության կատեգորիա</th>
                                        <th width="10%">Գործողություն</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for ="(item,index) in allData" :key="item.id">
                                            <td>{{++index}}</td>
                                            <td>{{item.title}}</td>

                                            <td>
                                                <div class="dropdown action" >
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <router-link class="dropdown-item"  :to="{name:'messages-categories.edit', params: { id: item.id } }">
                                                            <i class="bx bx-edit-alt me-1"></i>Խմբագրել
                                                        </router-link>

                                                        <button type="button" class="dropdown-item click_delete_item"

                                                              @click = "deleteItem(item.id,'message-categories')"><i
                                                                class="bx bx-trash me-1"></i>
                                                            Ջնջել</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                            </table>

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

