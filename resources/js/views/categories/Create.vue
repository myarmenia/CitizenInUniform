<script setup>
import { useRouter } from "vue-router"
import { ref, reactive } from  "vue"

const router = useRouter()

let category = ref([])
let errors = ref([])

const form = reactive({
    title: ''
})

const categorySave = async () => {
    // let response = await axios.post('/api/categories', form)
    // .then((response) => {

    //     router.push('/categories')
    //     toast.fire({icon: 'success', title: 'Գործողությունը բարեհաջող կատարված է'})

    // })
    // .catch((error) => {
    //     if(error.response.status === 422){
    //         errors.value = error.response.data.errors
    //     }

    // })


    try {
        await axios.post('/api/categories', form)

        router.push('/categories')
        toast.fire({icon: 'success', title: 'Գործողությունը հաջողությամբ կատարված է'})
    } catch (error) {
            errors.value = error.response.data.errors

    }

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
                    <li class="breadcrumb-item active">Ստեղծել</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Ստեղծել նոր բաժին </h5>

                                <div class="row mb-3">
                                    <label for="title" class="col-sm-3 col-form-label">Վերնագիր </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="form.title" id="title"
                                            placeholder="Վերնագիր" >
                                        <div class="mb-3 row " v-if="errors.title">
                                            <p class="col-sm-10 text-danger fs-6" v-for="error in errors.title">{{ error }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" @click="categorySave">Ստեղծել</button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

</template>
