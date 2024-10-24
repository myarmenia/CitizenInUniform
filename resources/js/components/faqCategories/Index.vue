<script setup>
import { useRouter } from "vue-router"
import { ref, onMounted,watch  } from  "vue"

const router = useRouter()



let products = ref([])
let links = ref([])
let searchQuery = ref('')
// =======show images from folder==========
 const ourImage = (img) =>{
    return "/upload/"+img
 }

onMounted(async () => {
    getProducts()
})
watch(searchQuery,() => {
    getProducts()
})



const newProduct = () => {
    router.push('/products/create')

}

// const getProducts = async () => {
//     let response = await axios.get ( '/api/products?&searchQuery='+searchQuery.value)
//     .then((response) => {
// console.log(response.data.products)
//         products.value = response.data.products.data
//         links.value = response.data.products.links
//     })
// }
// const changePage =(link) =>{
//     console.log(link)
//     if(!link.url || link.active){
//         return
//     }
//     axios.get(link.url)
//         .then((response) =>{
//             products.value = response.data.products.data
//             links.value = response.data.products.link
//         })
// }

//  const  onEdit = (id) =>{
//     console.log(id)
//         router.push(`/products/${id}/edit`)
//     }

    // =======delete==============

    // const deleteProduct = (id) =>{
    //         Swal.fire({
    //         title: "Are you sure?",
    //         text: "You won't be able to revert this!",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         cancelButtonColor: "#d33",
    //         confirmButtonText: "Yes, delete it!"
    //         })
    //         .then((result) => {
    //             if (result.isConfirmed) {
    //                 axios.delete(`/api/products/${id}`)
    //                     .then(()=>{
    //                        Swal.fire({
    //                             title: "Deleted!",
    //                             text: "Your file has been deleted.",
    //                             icon: "success"
    //                             });

    //                             getProducts()

    //                     })
    //             }
    //         });
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
                                <li class="breadcrumb-item active">Մենյուի բաժիններ </li>
                                <li class="breadcrumb-item active">Ցանկ</li>
                            </ol>
                        </nav>
                        </h5>
                        <div class="pull-right d-flex justify-content-end m-3" >
                            <a class="btn btn-primary  mb-2" href=""><i class="fa fa-plus"></i> Ստեղծել նոր բաժին</a>
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
            <!-- @foreach ($data as $key => $category)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $category->title }}</td>

                    <td>
                        {{-- <a class="btn btn-primary btn-sm" href=""><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                        <form method="POST" action="" style="display:inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form> --}}
                        <div class="dropdown action"data-id="{{ $category->id }}" data-tb-name="category">
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
            @endforeach -->
        </table>

    </main>


</template>

