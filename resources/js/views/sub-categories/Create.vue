<script setup>
import { useRouter } from "vue-router"
import { ref, reactive, onMounted, onUnmounted } from  "vue"
import api, { initApi } from "../../api";
import { initTinyMCE } from '@/tinymce-init.js';


const router = useRouter()
initApi(router); // Initialize the API with the router

let errors = ref([])
let activeCategories = ref([])
const selectedCategory = ref('Ընտրել մենյուի կատեգորիան');


const form = reactive({
    category_id: '',
    title: '',
    content: '',
    files: [],
    dataFiles: [],
    errorMessage: ''
})

onMounted(async () => {
    getActiveCategies()
    initTinyMCE()
})


onUnmounted(() => {
    tinymce.remove();
});


const getActiveCategies = async () => {
    let response =  api.value.get ( '/api/auth/active-categories')
    .then((response) => {

       activeCategories.value = response.data.result

    })
}


const handleSelectionChange = () => {
    form.category_id = selectedCategory.value

}

const fileInput = ref(null); // Ссылка на элемент input
const MAX_SIZE = 50 * 1024 * 1024; // Максимальный размер файла 50MB

const formatSize = (size) => {
  const units = ['Բ', 'ԿԲ', 'ՄԲ', 'ԳԲ'];
  let index = 0;
  let formattedSize = size;

  while (formattedSize > 1024 && index < units.length - 1) {
    formattedSize /= 1024;
    index++;
  }

  return `${formattedSize.toFixed(2)} ${units[index]}`;
};



const handleFileChange = (e) => {
    const selectedFiles = e.target.files;

    form.errorMessage = ''; // Сброс сообщения об ошибке

    // Проверка размера файлов
    const invalidFiles = Array.from(selectedFiles).filter(file => file.size > MAX_SIZE);
    if (invalidFiles.length) {
        form.errorMessage = `ֆաիլի առավելագույն չախը ${formatSize(MAX_SIZE)}.`;
        return;
    }

    // Очистка массивов перед добавлением новых файлов
    form.dataFiles = [];
    form.files = [];

    Array.from(selectedFiles).forEach((file) => {
        // Сохраняем оригинальные объекты File
        form.dataFiles.push(file);
    });

    Array.from(selectedFiles).forEach((file) => {
        const reader = new FileReader();

        reader.onload = () => {
            form.files.push({ src: reader.result, type: file.type});
        };

        reader.readAsDataURL(file);
    });

};


const removeFile = (index) => {
  form.files.splice(index, 1); // Удаляем файл по индексу из массива files
  form.dataFiles.splice(index, 1);

  console.log(files)
};


const dataSave = async () => {
    const formData = new FormData();

    form.content = tinymce.get('tiny-editor').getContent()

    formData.append('category_id', form.category_id);
    formData.append('title', form.title);
    formData.append('content', form.content);

    form.dataFiles.forEach((file) => {
        formData.append('files[]', file); // Добавляем оригинальные объекты File
    });

    let response =  api.value.post('/api/auth/sub-categories', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then((response) => {

        router.push('/sub-categories')
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
                                    <label for="title" class="col-sm-3 col-form-label">Կատեգորիա </label>
                                    <div class="col-sm-9">

                                        <select class="form-select"  v-model="selectedCategory"  @change="handleSelectionChange" >
                                                <option disabled selected>Ընտրել մենյուի կատեգորիան </option>
                                                <option v-for="category in activeCategories" :key="category.id" :value="category.id">{{category.title}}</option>
                                        </select>

                                        <div class="mb-3 row " v-if="errors.category_id">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorCategoryId in errors.category_id">{{ errorCategoryId }}
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
                                        <input type="file" class="form-control" id="files" @change="handleFileChange" multiple ref="fileInput">
                                        <p class="col-sm-10 text-danger fs-6 mt-2" v-if="form.errorMessage">{{ form.errorMessage }} </p>
                                        <p class="col-sm-10 text-danger fs-6" v-for="errorFile in errors.files">{{ errorFile }} </p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="files" class="col-sm-3 col-form-label"></label>
                                    <div class="d-flex justify-content-start col-sm-9 flex-wrap">
                                        <div v-for="(file, index) in form.files" :key="index" class="files d-flex align-items-start">

                                            <img v-if="file.type.startsWith('image/')" :src="file.src" alt="Изображение" class="image img-thumbnail mx-0 my-2" />
                                            <video v-else-if="file.type.startsWith('video/')" :src="file.src" controls class="video img-thumbnail mx-0 my-2"></video>

                                            <span class="deleteFile" @click="removeFile(index)"><i class="bx bx-trash me-1"></i></span>
                                        </div>
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
<style scoped>

.image,
.video {
  max-width: 150px;
  max-height: 150px;
  margin-right: 10px;
}

.deleteFile{
    cursor: pointer;
}

</style>
