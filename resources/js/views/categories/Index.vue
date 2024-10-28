<script setup>
import { useRouter } from "vue-router"
import { ref, onMounted } from  "vue"

    const router = useRouter()

    let categories = ref([])
    // let links = ref([])

    onMounted(async () => {
        getCategories()
    })

    const getCategories = async () => {
        let response = await axios.get ( '/api/categories')
        .then((response) => {
            categories.value = response.data.data
            // links.value = response.data.products.links
        })
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
                                        <router-link class="btn btn-primary  mb-2" to="/categories/create"><i class="fa fa-plus"></i> Ստեղծել նոր բաժին</router-link>
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
                                        <td>{{ index }}</td>
                                        <td>{{ category.title }}</td>
                                        <td>
                                            <div class="dropdown action" data-id="{{ category.id }}" data-tb-name="category">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <router-link class="dropdown-item" :to="{name: 'categories.edit', params: { id: category.id } }">
                                                        <i class="bx bx-edit-alt me-1"></i>Խմբագրել</router-link>

                                                    <button type="button" class="dropdown-item click_delete_item"
                                                        data-bs-toggle="modal" data-bs-target="#smallModal"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Ջնջել</button>
                                                </div>
                                            </div>
                                        </td>
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
