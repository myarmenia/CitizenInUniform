<script setup>
import  { ref, onMounted } from "vue"


 let allData = ref([])

onMounted(async () =>{
    getAllData()
})

const getAllData = async () => {
    let response = await axios.get('/api/faq-category-subcategory')
        .then((response)=>{

            allData.value = response.data.faqCategories
            // .data
            // links.value =  response.data.faqCategories.links


        })
}

</script>
<template>


    <main id="main" class="main">

        <div class="row mycss">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <div class = "d-flex justify-content-between">
                        <h5 class="card-title">

                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"> ՀՏՀ</li>
                                    <li class="breadcrumb-item active">Ցանկ</li>
                                </ol>
                            </nav>
                        </h5>
                        <div class="pull-right d-flex justify-content-end m-3" >
                             <router-link class="btn btn-primary  mb-2"  :to="{name: 'faqCategorySubcategory.cteate'}">
                            <i class="fa fa-plus"></i> Ստեղծել</router-link>
                        </div>
                    </div>
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
                    <tr v-for ="category in faqCategories" :key="category.id">
                        <td>{{category.id}}</td>
                        <td>{{category.title}}</td>
                        <td>{{category.status==0 ? 'Պասիվ' : 'Ակտիվ' }}</td>
                        <td>


                            <div class="dropdown action"  data-id="" data-tb-name="category">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"   @click="onEdit(category.id)"><i
                                            class="bx bx-edit-alt me-1"></i>Խմբագրել</a>
                                    <button type="button" class="dropdown-item click_delete_item"
                                        data-bs-toggle="modal" data-bs-target="#smallModal" @click = "deleteItem(category.id)"><i
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

    </main>


</template>
