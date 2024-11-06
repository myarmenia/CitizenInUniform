<script setup>
import { useRouter } from "vue-router"
import { ref, reactive } from  "vue"
import api, { initApi } from "../../api";

const router = useRouter()
initApi(router); // Initialize the API with the router

let category = ref([])
let errors = ref([])

const form = reactive({
    title: '',
    file: '',
    dataFile: ''
})

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

const categorySave = async () => {

    const formData = new FormData();

    formData.append('title', form.title);
    formData.append('file', form.dataFile)

    let response =  api.value.post('/api/auth/categories', formData, {
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
                                    <div v-if="form.file" class="d-flex justify-content-start col-sm-9 flex-wrap">
                                        <div class="files d-flex align-items-start">
                                            <img :src="form.file" alt="Изображение" class="image img-thumbnail mx-0 my-2" />
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

