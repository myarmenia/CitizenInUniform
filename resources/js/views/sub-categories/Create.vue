<script setup>
import { useRouter } from "vue-router"
import { ref, reactive, onMounted } from  "vue"
import { initTinyMCE } from '../../utils/tinymceConfig';

const router = useRouter()

let errors = ref([])
let allCategories = ref([])
const selectedCategory = ref(null);

const form = reactive({
    category_id: null,
    title: '',
    content: '',
    image: ''
})

onMounted(async () => {
    initTinyMCE()
    getAllCategies()
})

const getAllCategies = async () => {
    let response = await axios.get ( `/api/categories`)
    .then((response) => {
       allCategories.value = response.data.data
       console.log(allCategories)
    })
}

const handleSelectionChange = () => {
    form.category_id = selectedCategory.value

}

const getImage = () => {
    let img = '/iploade/no-image.png'
    if(form.files){
        console.log(form.files)
    }

    return img
}

const handleFileChange = (e) => {
    let file = e.target.files[0]

    let reader  = new FileReader()
    reader.onload = () => {
        form.image = reader.result
        // console.log( form, 5555555555)
    }

    reader.readAsDataURL(file)

}

const dataSave = async () => {

    form.content = tinymce.get('tiny-editor').getContent()

    let response = await axios.post('/api/sub-categories', form)
    .then((response) => {

        router.push('/sub-categories')
        toast.fire({icon: 'success', title: 'soccess message'})

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
            <h1>Մենյուի ենթաբաժիններ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">
                        <router-link class="dropdown-item" :to="{name: 'subCategories.index' }"> Ցանկ</router-link>
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
                            <h5 class="card-title">Ստեղծել նոր ենթաբաժին </h5>

                                <div class="row mb-3">
                                    <label for="title" class="col-sm-3 col-form-label">Վերնագիր </label>
                                    <div class="col-sm-9">

                                        <select class="form-select"  v-model="selectedCategory"  @change="handleSelectionChange" >
                                                <option value='' disabled selected>Ընտրել մենյուի կատեգորիան </option>
                                                <option v-for="category in allCategories" :key="category.id" :value="category.id">{{category.title}}</option>
                                        </select>

                                        <div class="mb-3 row " v-if="errors.title">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorTitle in errors.title">{{ errorTitle }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="title" class="col-sm-3 col-form-label">Վերնագիր </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="form.title" id="title"
                                            placeholder="Վերնագիր" >
                                        <div class="mb-3 row " v-if="errors.title">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorTitle in errors.title">{{ errorTitle }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="content" class="col-sm-3 col-form-label">Բովանդակություն </label>
                                    <div class="col-sm-9">

                                         <textarea class="tinymce-editor"  v-model="form.content" id="tiny-editor"></textarea>

                                        <div class="mb-3 row " v-if="errors.content">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorContent in errors.content">{{ errorContent }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="files" class="col-sm-3 col-form-label">Ֆայլեր </label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" id="files" @change="handleFileChange" >
                                        <img :src="getImage()">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" @click="dataSave">Ստեղծել</button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

</template>
