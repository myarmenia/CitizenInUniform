<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, reactive, onMounted, onUnmounted, watch } from  "vue"
import { initTinyMCE } from '../../utils/tinymceConfig';


const router = useRouter()
const route = useRoute()


let errors = ref([])
let activeCategories = ref([])

const form = reactive({
    category_id: '',
    title: '',
    content: '',
    files: [],
    dataFiles: [],
    responseFiles: [],
    errorMessage: ''

})


onMounted(async () => {
    getSubCategy()
    getActiveCategies()
    // initTinyMCE()
    tinymce.init({
    selector: '#tiny-editor',
    // setup(editor) {
    //   editor.on('init', () => {
    //     editor.setContent(form.content); // Установка начального значения
    //   });

    //   editor.on('input', () => {
    //     form.content = editor.getContent(); // Обновление form.content при изменении
    //   });
    // }
  });


})

onUnmounted(() => {

    tinymce.remove();
});

watch(() => form.content, (newContent) => {
  const editor = tinymce.get('tiny-editor');
  if (editor && editor.getContent() !== newContent) {
    editor.setContent(newContent);
  }
});


const getActiveCategies = async () => {
    let response = await axios.get ( `/api/active-categories`)
    .then((response) => {
       activeCategories.value = response.data.result

    })
}

const getSubCategy = async () => {
    let response = await axios.get ( `/api/sub-categories/${route.params.id}`)
    .then((response) => {

        let result = response.data.result

            form.category_id = result.category_id
            form.title = result.title
            form.content = result.content
            form.responseFiles = result.files

    })
}


const fileInput = ref(null); // Ссылка на элемент input
const MAX_SIZE = 5 * 1024 * 1024; // Максимальный размер файла 5MB

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
    console.log(form.dataFiles, form.files)

};


const removeFile = (index) => {
  form.files.splice(index, 1); // Удаляем файл по индексу из массива files
  form.dataFiles.splice(index, 1);

};

const removeFileFromDB = async(index, subCategoryId) => {

    let response = await axios.get(`/api/delete-item/files/${subCategoryId}`)
        .then((response) => {

            form.responseFiles.splice(index, 1)
            toast.fire({icon: 'success', title: 'Գործողությունը կատարված է'})
        })
 }


const dataEdit = async () => {
    const formData = new FormData();

    form.content = tinymce.get('tiny-editor').getContent()

    formData.append('category_id', form.category_id);
    formData.append('title', form.title);
    formData.append('content', form.content);

    form.dataFiles.forEach((file) => {
        formData.append('files[]', file); // Добавляем оригинальные объекты File
    });

    formData.append('_method', 'PUT');

    let response = await axios.post(`/api/sub-categories/${route.params.id}`, formData, {
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
                    <li class="breadcrumb-item active">Խմբագրել</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Խմբագրել ենթաբաժինը </h5>

                                <div class="row mb-3">
                                    <label for="title" class="col-sm-3 col-form-label">Կատեգորիա </label>
                                    <div class="col-sm-9">

                                        <select class="form-select"  v-model="form.category_id"  >
                                                <option disabled >Ընտրել մենյուի կատեգորիան </option>
                                                <option v-for="category in activeCategories" :key="category.id" :value="category.id" > {{category.title}} </option>
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
                                            placeholder="Վերնագիր" value="form.title">
                                        <div class="mb-3 row " v-if="errors.title">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorTitle in errors.title">{{ errorTitle }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="content" class="col-sm-3 col-form-label">Բովանդակություն </label>
                                    <div class="col-sm-9">

                                         <textarea class="tinymce-editor"  v-model="form.content" id="tiny-editor">{{ form.content }}</textarea>

                                        <div class="mb-3 row " v-if="errors.content">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorContent in errors.content">{{ errorContent }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="files" class="col-sm-3 col-form-label">Ֆայլեր </label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" id="files" @change="handleFileChange" multiple>
                                        <p class="col-sm-10 text-danger fs-6 " v-if="form.errorMessage">{{ form.errorMessage }} </p>

                                    </div>
                                </div>

                                 <div class="row mb-3">
                                    <label for="files" class="col-sm-3 col-form-label"></label>
                                    <div class="d-flex justify-content-start col-sm-9 flex-wrap">
                                        <div v-for="(file, index) in form.responseFiles" :key="index" class="files d-flex align-items-start">
                                            <img v-if="file.type == 'image'" :src="file.path" alt="Изображение" class="image img-thumbnail mx-0 my-2" />
                                            <video v-else-if="file.type == 'video'" :src="file.path" controls class="video img-thumbnail mx-0 my-2"></video>

                                            <span class="deleteFile" @click="removeFileFromDB(index, file.id)" id="a6">
                                                <i class="bx bx-trash me-1"></i>
                                            </span>
                                        </div>

                                        <div v-for="(file, index) in form.files" :key="index" class="files d-flex align-items-start">

                                            <img v-if="file.type.startsWith('image/')" :src="file.src" alt="Изображение" class="image img-thumbnail mx-0 my-2" />
                                            <video v-else-if="file.type.startsWith('video/')" :src="file.src" controls class="video img-thumbnail mx-0 my-2"></video>

                                            <span class="deleteFile" @click="removeFile(index)"><i class="bx bx-trash me-1"></i></span>
                                        </div>

                                    </div>
                                    <div v-if="responseMessage" class="alert alert-success mt-3">{{ responseMessage }}</div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" @click="dataEdit">Պահպանել</button>
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
