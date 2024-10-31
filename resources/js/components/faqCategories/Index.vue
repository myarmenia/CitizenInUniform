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
                            <li class="breadcrumb-item active">Օգտագործողներ </li>
                            <li class="breadcrumb-item active">Ցանկ</li>
                        </ol>
                    </nav>
                    </h5>
                    <div class="pull-right d-flex justify-content-end m-3" >
                        <a class="btn btn-primary  mb-2" ><i class="fa fa-plus"></i> Ստեղծել նոր Օգտատեր</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

sssssssssssssssssssssssssssssssssssss

    <!-- <table class="table table-bordered">
        <tr>
            <th>Հ/Հ</th>
            <th>Անուն</th>
            <th>Էլ․հասցե</th>
            <th>Դերեր</th>
            <th width="280px">Գործողություն</th>
        </tr>
        @foreach ($data as $key => $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <label class="badge bg-primary">{{ $v }}</label>
                    @endforeach
                @endif
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table> -->

    <!-- {!! $data->links('pagination::bootstrap-5') !!} -->

    </main>


</template>

