
<script setup>
import { onMounted, reactive, ref, onUnmounted } from "vue"
import { useRouter } from "vue-router"
import { initTinyMCE } from '../../utils/tinymceConfig';

const router = useRouter()
let errors = ref([])

const form = reactive({
    title:"",
    f_a_q_category_id:'',
    content:""
})


const handleSave = () =>{
    errors.value = {};

    form.content = tinymce.get('tiny-editor').getContent()
    axios.post('/api/faq-category-subcategory',form)
    .then((response)=>{
        router.push('/faq-category-subcategory')
        toast.fire({icon:"success",title:"Գործողությունը հաջողությամբ կատարված է"})
    })
     .catch((error) => {

                if (error.response && error.response.status === 422) {

                    const allErrors = error.response.data.errors;
                    for (const field in allErrors) {
                        if (allErrors.hasOwnProperty(field)) {
                            errors.value[field] = allErrors[field][0]; // Get only the first error message
                        }
                    }
                }

            })

}

let faqCategories = ref([]);

onMounted( async () =>{
    getAllFaqCategory()
    initTinyMCE()

})

onUnmounted(() => {
    if (tinymce.get('tiny-editor')) {
        tinymce.get('tiny-editor').remove();
    }
});

const getAllFaqCategory = async () => {
    let response = await axios.get('/api/all-faq-categories')
        .then((response)=>{
            console.log(response.data.faqCategories)
            faqCategories.value = response.data.faqCategories


        })
}

const selectedCategory = ref('Ընտրել ՀՏՀ կատեգորիա');
const handleSelectionChange = () => {
    form.f_a_q_category_id=selectedCategory.value

}


</script>
<template>
    <main id="main" class="main">

    <div class="pagetitle">
      <h1>ՀՏՀ ենթակատեգորիա</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><router-link to="/faq-category-subcategory">Ցանկ</router-link></li>
          <li class="breadcrumb-item active">Ստեղծել</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-10">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <!-- General Form Elements -->
            </h5>

              <!-- General Form Elements -->
              <!-- <form> -->
               <div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">ՀՏՀ կատեգորիա</label>
                  <div class="col-sm-9">
                    <select class="form-select" aria-label="Default select example" v-model="selectedCategory" @change="handleSelectionChange">
                        <option   disabled  > Ընտրել ՀՏՀ կատեգորիա </option>
                        <option v-for="category in faqCategories" :key="category.id" :value = "category.id">{{category.title}}</option>
                    </select>
                    <small style = "color:red" v-if="errors.f_a_q_category_id">{{errors.f_a_q_category_id }}</small>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Հարցի տեքստ</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" v-model="form.title">
                    <small style = "color:red" v-if="errors.title">{{errors.title}}</small>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Հարցի պատասխան</label>
                  <div class="col-sm-9">
                    <textarea class="tinymce-editor"  id="tiny-editor" v-model="form.content"></textarea>

                    <small style = "color:red" v-if="errors.content">{{errors.content}}</small>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">
                    <!-- Submit Button -->
                </label>
                  <div class="col-sm-9">
                    <button class="btn btn-primary" @click="handleSave">Ստեղծել</button>
                  </div>
                </div>

              <!-- </form> -->
               </div>
              <!-- End General Form Elements -->

            </div>
          </div>

        </div>


      </div>


    </section>

  </main>
</template>
