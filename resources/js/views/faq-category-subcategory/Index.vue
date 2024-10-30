<script setup>
import  { ref, onMounted } from "vue"
import {useRouter } from "vue-router"








const router = useRouter()

 let allData = ref([])


onMounted(async () =>{
    getAllData()


})

const getAllData = async () => {
    let response = await axios.get('/api/faq-category-subcategory')
        .then((response)=>{

            allData.value = response.data.data
            // .data
            // links.value =  response.data.faqCategories.links


        })
}

const  onEdit = (id) =>{
    router.push(`/faq-category-subcategory/${id}/edit`)
}
// for modal
// const urlValue = ref('');

const deleteItem = (id,tb_name) =>{

const newUrl  = `/api/delete-item/${tb_name}/${id}`

    //   urlValue.value = newUrl;



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
                                        <th width="10%">Գործողություն</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for ="item in allData" :key="item.id">
                                            <td>{{item.id}}</td>
                                            <td>{{ item.f_a_q_category_name }}</td>
                                            <td>{{item.title}}</td>

                                            <td>

                                                <div class="dropdown action" >

                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"   @click="onEdit(item.id)"><i
                                                                class="bx bx-edit-alt me-1"></i>Խմբագրել</a>


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
                            <div class="pagination">
                                <a
                                        href="#"
                                        class="btn"
                                        v-for="(link,index) in links"
                                        :key="index"
                                        v-html="link.lable"
                                        :class="{active: link.active,disabled:!link.url }"
                                        @click="changePage(link)"
                                            ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <!-- <ModalDelete  :url='urlValue' /> -->


</template>

