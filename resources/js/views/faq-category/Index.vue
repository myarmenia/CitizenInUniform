<script setup>
import {ref, onMounted } from "vue"
import { useRouter } from "vue-router"
const router = useRouter()

let faqCategories = ref([]);
let links = ref([]);


onMounted(async () =>{
    getFaqCategories()
})
const getFaqCategories = async () => {
    let response = await axios.get('/api/list-faq-categories')
        .then((response)=>{

            faqCategories.value = response.data.faqCategories
            // .data
            // links.value =  response.data.faqCategories.links


        })
}

const changePage =(link) =>{
    console.log(link)
    if(!link.url || link.active){
        return
    }
    axios.get(link.url)
        .then((response) =>{
           faqCategories.value = response.data.faqCategories.data
            links.value = response.data.faqCategories.link
        })
}

    const  onEdit = (id) =>{

        router.push(`/faq-categories/${id}/edit`)
    }
    const deleteItem = (id) =>{

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
                    axios.delete(`/api/faq-categories/${id}`)
                        .then(()=>{
                           Swal.fire({
                                title: "Ջնջված է",
                                text: "Ձեր գրառումը բարեհաջող ջնջվել է",
                                icon: "success",
                                confirmButtonText: "Լավ",
                                //   // dont work css
                                    customClass: {
                                        icon: 'small-icon'  // Add custom class for the icon
                                    }
                                });
                                // dont work css
                                didRender: () => {
                                const icon = document.querySelector('.small-icon .swal2-icon');
                                console.log(icon)
                                if (icon) {
                                    icon.style.fontSize = '5px';
                                    icon.style.width = '50px';
                                    icon.style.height = '50px';
                                }
                                }

                                getFaqCategories()

                        })
                }
            });
    }



</script>
<template>


    <main id="main" class="main">
        <div class="pagetitle">
            <h1>ՀՏՀ կատեգորիա</h1>
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
                                        <router-link class="btn btn-primary  mb-2" to="/faq-categories/create"><i class="fa fa-plus"></i> Ստեղծել</router-link>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


</template>
<style scoped>
.small-icon  {
    font-size: 5px;  /* Adjust the size */
    width: 50px;    /* Adjust the width */
    height: 50px;   /* Adjust the height */
}
/* .mycss{
    background-color:green
} */
</style>
