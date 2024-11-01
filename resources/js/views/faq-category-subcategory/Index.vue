<script setup>
import  {reactive, ref, onMounted } from "vue"
import {useRouter } from "vue-router"








const router = useRouter()

 let allData = ref([])
 let links = ref([]);
 let  faqArray=ref([])
 let activePage = ref(1)
 let lastPage = ref(1)


onMounted(async () =>{
    getAllData()


})

const getAllData = async () => {
    let response = await axios.get(`/api/faq-category-subcategory?page=${activePage.value}`)
        .then((response)=>{
console.log(response.data.result.data)

            allData.value = response.data.result.data
            links.value =  response.data.result.links
            faqArray.value = response.data.result.data.map(item => item.status);
            lastPage.value = response.data.result.last_page



        })
}

const  onEdit = (id) =>{
    router.push(`/faq-category-subcategory/${id}/edit`)
}
// for modal
// const urlValue = ref('');

const deleteItem = (id,tb_name) =>{

const newUrl  = `/api/delete-item/${tb_name}/${id}`


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
            axios.get(newUrl)
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
const form = reactive({
    id:'',
    tb_name: '',
    status:'',
    field_name:'',

})


const changePage =(link) =>{
    console.log(link,"")

    if(!link.url || link.active){
        return
    }
    activePage.value = link.label
    axios.get(link.url)
        .then((response) =>{
            allData.value = response.data.result.data
           links.value =  response.data.result.links

        })
}

const changeStatus = (index, event, id, tb_name, field_name) => {

    let changedStatus = event.target.checked
    faqArray.value[index] = changedStatus; // Update the checked state for the specific checkbox

    form.id = id
    form.tb_name = tb_name
    form.status = changedStatus
    form.field_name = field_name

    axios.post('/api/change-status',form)
    .then((response)=>{
        getAllData(activePage.value)

        toast.fire({icon:"success",title:"Գործողությունը հաջողությամբ կատարված է"})
    })


};



</script>
<template>


    <main id="main" class="main">
        <div class="pagetitle">
            <h1>ՀՏՀ  ենթակատեգորիա</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">Ցանկ</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="card">
                        <div class="card-body">
                            <div class="pull-left">
                                <div class = "d-flex justify-content-between">
                                    <h5 class="card-title">


                                    </h5>
                                    <div class="pull-right d-flex justify-content-end m-3" >
                                        <router-link class="btn btn-primary  mb-2"  :to="{name: 'faqCategorySubcategory.cteate'}">
                                        <i class="fa fa-plus"></i> Ստեղծել</router-link>
                                    </div>
                                </div>
                            </div>





                           <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Հ/Հ</th>
                                        <th>ՀՏՀ կատեգորիա</th>
                                        <th>Հարց</th>
                                        <th>Կարգավիճակ</th>
                                        <th width="10%">Գործողություն</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for ="(item,index) in allData" :key="item.id">
                                             <td>{{++index}}</td>
                                            <td>{{ item.f_a_q_category_name }}</td>
                                            <td>{{item.title}}</td>
                                            <td>

                                                <button
                                                    type="button"
                                                    :class="item.status == 1 ? 'btn btn-success' : 'btn btn-danger '">
                                                    {{ item.status == 1 ? 'Ակտիվ' : 'Պասիվ' }}
                                                </button>

                                            </td>

                                            <td>

                                                <div class="dropdown action" >

                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <router-link class="dropdown-item"   :to="{name:'faqCategorySubcategory.edit', params: { id: item.id } }"><i
                                                                class="bx bx-edit-alt me-1"></i>Խմբագրել
                                                        </router-link>
                                                        <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input change_status" type="checkbox"
                                                                    role="switch"

                                                                    :checked="item.status"
                                                                    @change="changeStatus(index, $event, item.id,'f_a_q_sub_categories','status')"
                                                                >
                                                            </div> Կարգավիճակ

                                                        </a>


                                                        <button type="button" class="dropdown-item click_delete_item"
                                                                @click = "deleteItem(item.id,'f_a_q_sub_categories')"
                                                              >
                                                              <i
                                                                class="bx bx-trash me-1"></i>
                                                            Ջնջել</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                            </table>
                            <nav aria-label=""  v-if="lastPage > 1" class="d-flex justify-content-end">
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
    <!-- <ModalDelete  :url='urlValue' /> -->


</template>

