<script setup>
// import { useRouter } from "vue-router"

// const router = useRouter()

// const createFaqCategory = () =>{
//     router.push('/faq-categories/create')
// }

</script>
<template>


    <main id="main" class="main">

        <div class="row">
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
                             <router-link class="btn btn-primary  mb-2"  to="/faq-categories/create">
                            <i class="fa fa-plus"></i> Ստեղծել</router-link>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <table class="table table-bordered">
            <tr>
                <th>Հ/Հ</th>
                <th>Վերնագիր</th>
                <th width="10%">Գործողություն</th>
            </tr>

                <tr>
                    <td>1</td>
                    <td>1</td>

                    <td>


                        <div class="dropdown action"  data-id="" data-tb-name="category">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href=""><i
                                        class="bx bx-edit-alt me-1"></i>Խմբագրել</a>
                                <button type="button" class="dropdown-item click_delete_item"
                                    data-bs-toggle="modal" data-bs-target="#smallModal"><i
                                        class="bx bx-trash me-1"></i>
                                    Ջնջել</button>
                            </div>
                        </div>
                    </td>
                </tr>

        </table>

    </main>


</template>
