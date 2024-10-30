<script setup>
import { useRouter } from "vue-router"
import { ref, onMounted } from  "vue"

const router = useRouter()

let categories = ref([])
let links = ref([])

onMounted(async () => {
    getCategories()
})

const getCategories = async () => {
    let response = await axios.get ( '/api/categories')
    .then((response) => {
        console.log(response)
        categories.value = response.data.data.data
        links.value = response.data.data.links
        console.log(response.data.data.links[3].label)
    })
}

const changePage =(link) =>{
    console.log(link)
    if(!link.url || link.active){
        return
    }
    axios.get(link.url)
        .then((response) =>{
           categories.value = response.data.data.data
            links.value = response.data.data.links
        })
}

const deleteItem = (id, tb_name) =>{
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
                                    <div class="pull-right d-flex justify-content-end m-3" >
                                        <router-link class="btn btn-primary  mb-2" to="/categories/create"><i class="fa fa-plus"></i> Ստեղծել</router-link>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>Հ/Հ</th>
                                        <th>Վերնագիր</th>
                                        <th width="10%">Գործողություն</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(category, index) in categories">
                                        <td>{{ ++index }}</td>
                                        <td>{{ category.title }}</td>
                                        <td>
                                            <div class="dropdown action" >
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <router-link class="dropdown-item" :to="{name: 'categories.edit', params: { id: category.id } }">
                                                        <i class="bx bx-edit-alt me-1"></i>Խմբագրել</router-link>

                                                    <button type="button" class="dropdown-item click_delete_item" @click = "deleteItem(category.id,'categories')"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Ջնջել</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- End Bordered Table -->

                            <nav aria-label="" class="d-flex justify-content-end">
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
