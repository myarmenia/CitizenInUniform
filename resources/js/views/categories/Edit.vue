<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted } from  "vue"
import api, { initApi } from "../../api";

const router = useRouter()
const route = useRoute()
initApi(router);

let category = ref([])
let errors = ref([])

const form = reactive({
    title: '',
    file: '',
    dataFile: '',
    responseFile: '',
})

onMounted(async () => {
    getCategy()
})


const getCategy = async () => {
    let response = api.value.get( `/api/auth/categories/${route.params.id}`)
    .then((response) => {

       form.title = response.data.result.title
       form.file = response.data.result.path
       console.log(form.file)

    })
}

const handleFileChange = (e) => {

    const selectedFile = e.target.files[0];
          form.dataFile = selectedFile

    if (selectedFile) {
        const reader = new FileReader();

        reader.onload = () => {
            form.file = reader.result
        };

        reader.readAsDataURL(selectedFile);
    }
};

const categoryEdit = async () => {
    const formData = new FormData();

    formData.append('title', form.title);
    formData.append('file', form.dataFile)

    formData.append('_method', 'PATCH');

    let response = api.value.post(`/api/auth/categories/${route.params.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then((response) => {

            router.push('/categories')
            toast.fire({icon: 'success', title: 'Գործողությունը հաջողությամբ կատարված է'})

        })
        .catch((error) => {
            errors.value = []
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
                                    <label for="files" class="col-sm-3 col-form-label">Ֆայլեր </label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" @change="handleFileChange" accept="image/*">

                                        <div class="mb-3 row " v-if="errors.file">
                                            <p class="col-sm-10 text-danger fs-6" v-for="error in errors.file">{{ error }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="files" class="col-sm-3 col-form-label"></label>
                                    <div class="d-flex justify-content-start col-sm-9 flex-wrap">
                                        <div class="files d-flex align-items-start">
                                            <img :src="form.file" alt="Изображение" class="image img-thumbnail mx-0 my-2" />
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
<style scoped>

.image,
.video {
  max-width: 100px;
  max-height: 100px;
  margin-right: 10px;
}

.deleteFile{
    cursor: pointer;
}

</style>
