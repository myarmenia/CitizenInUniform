<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted } from  "vue"

const router = useRouter()
const route = useRoute()

let category = ref([])
let errors = ref([])

const form = reactive({
    title: ''
})

onMounted(async () => {
    getCategy()
})

const getCategy = async () => {
    let response = await axios.get ( `/api/categories/${route.params.id}`)
    .then((response) => {

       form.title = response.data.data.title
    })
}

const categoryEdit = async () => {
    let response = await axios.put(`/api/categories/${route.params.id}`, form)
    .then((response) => {

        router.push('/categories')
        toast.fire({icon: 'success', title: 'Գործողությունը բարեհաջող կատարված է'})
    })
    .catch((error) => {
        if(error.response.status === 422){

            errors.value = error.response.data.errors
        }
    })
}



</script>


<template>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Մենյուի բաժիններ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">
                        <router-link class="dropdown-item" :to="{name: 'categories.index' }"> Ցանկ</router-link>
                    </li>
                    <li class="breadcrumb-item active">Խմբագրել</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Խմբագրել բաժինը </h5>

                                <div class="row mb-3">
                                    <label for="title" class="col-sm-3 col-form-label">Վերնագիր </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="form.title" id="title"
                                            placeholder="Վերնագիր" value="form.title">
                                        <div class="mb-3 row " v-if="errors.title">
                                            <p class="col-sm-10 text-danger fs-6" v-for="error in errors.title">{{ error }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" @click="categoryEdit">Պահպանել</button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

</template>
