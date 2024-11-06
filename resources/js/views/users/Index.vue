<script setup>
import { useRouter } from "vue-router"
import { ref, reactive, onMounted } from  "vue"
import api, { initApi } from "../../api";

const router = useRouter()
initApi(router); // Initialize the API with the router

let allData = ref([])
let links = ref([])
let activePage = ref(1)
let lastPage = ref(1)
let  statusArray=ref([])

const form = reactive({
    id:'',
    tb_name: '',
    status:'',
    field_name:'',

})

onMounted(async () => {
    getAllData()
})

const getAllData = async () => {
    let response = api.value.get ( `/api/auth/users?page=${activePage.value}`)
    .then((response) => {
        let result = response.data.result
        lastPage.value = result.last_page
        allData.value = result.data
        statusArray.value = result.data.map(item => item.status);
        links.value = result.links

    })
}

const changePage =(link) =>{

    if(!link.url || link.active){
        return
    }

    activePage.value = link.label

    api.value.get(link.url)
        .then((response) =>{
           subCategories.value = response.data.result.data
           links.value = response.data.result.links
        })
}



const changeStatus = (index, event, id, tb_name, field_name) => {

    let changedStatus = event.target.checked
    statusArray.value[index] = changedStatus; // Update the checked state for the specific checkbox

    form.id = id
    form.tb_name = tb_name
    form.status = changedStatus
    form.field_name = field_name

    api.value.post('/api/auth/change-status',form)
    .then((response)=>{
        getSubCategories(activePage.value)

        toast.fire({icon:"success",title:"Գործողությունը հաջողությամբ կատարված է"})
    })


};

const deleteItem = (id, tb_name) =>{
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
                           getSubCategories()
                    }

                })
        }
    });
}


</script>


<template>
 <main id="main" class="main">

        <div class="pagetitle">
            <h1>Օգտատերեր</h1>
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
                                    <h5 class="card-title">Օգտատերեր</h5>
                                    <div class="pull-right d-flex justify-content-end m-3" >
                                        <router-link class="btn btn-primary  mb-2" :to="{name: 'users.create'}"><i class="fa fa-plus"></i> Ստեղծել </router-link>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <!-- <tr>
                                    <th>Հ/Հ</th>
                                    <th>Անուն</th>
                                    <th>Էլ․հասցե</th>
                                    <th>Դերեր</th>
                                    <th width="280px">Գործողություն</th>
                                </tr> -->
                              <tr v-for="(user, index) in allData" :key="user.id">

                                    <td>{{ ++index }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <!-- <td> -->
                                    <!-- @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                        <label class="badge bg-primary">{{ $v }}</label>
                                        @endforeach
                                    @endif -->
                                    <!-- </td> -->
                                    <!-- <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                                        <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                        </form>
                                    </td> -->
                                </tr>
                            </table>

                            <!-- ==========links ================ -->
                            <!-- <nav aria-label="" v-if="lastPage > 1" class="d-flex justify-content-end">
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
                            </nav> -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

</template>
