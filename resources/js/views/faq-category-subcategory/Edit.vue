
<script setup>
import { onMounted, reactive, ref, onUnmounted, watch } from "vue"
import { useRouter, useRoute } from "vue-router"
import { initTinyMCE } from '../../utils/tinymceConfig';

const router = useRouter()
const route = useRoute()
let errors = ref([])
let faqCategories = ref([]);

const form = reactive({
    title:"",
    content:"",
})


onMounted(async () =>{
    getFaqCategorySubcategory()
    // initTinyMCE()
    tinymce.init({
        selector: '#tiny-editor'
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

const getFaqCategorySubcategory = async () => {

    let response =await axios.get(`/api/faq-category-subcategory/${route.params.id}`)
        .then((response)=>{
            let result=response.data.result
                form.title = result.faqCategorySubcategory.title
             form.content = result.faqCategorySubcategory.content

             form.f_a_q_category_id = result.faqCategorySubcategory.f_a_q_category_id
             faqCategories.value = result.faqCategory
             console.log(faqCategories)
             console.log(form,'form')

        })
}

 const updateData = () =>{
    errors.value = {};

        axios.put(`/api/faq-category-subcategory/${route.params.id}`,form)
            .then((response)=>{
                router.push('/faq-category-subcategory')

                toast.fire({icon:"success",title:"Գործողությունը հաջողությամբ կատարված է"})
            })
            .catch((error) => {
                if (error.response && error.response.status === 422) {

                    const allErrors = error.response.data.errors;
                        for (const field in allErrors) {
                            console.log(allErrors.hasOwnProperty(field))
                            if (allErrors.hasOwnProperty(field)) {
                                errors.value[field] = allErrors[field][0]; // Get only the first error message
                            }
                        }
                        }
            })
    }


</script>
<template>
    <main id="main" class="main">

    <div class="pagetitle">
      <h1>ՀՏՀ  ենթակատեգորիա</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><router-link :to="{name:'faqCategorySubcategory.index'}">Ցանկ</router-link></li>
          <li class="breadcrumb-item active">Խմբագրել</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-10">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <!-- Խմբագրել -->
                </h5>

              <!-- General Form Elements -->
              <!-- <form> -->
               <div>
                 <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">ՀՏՀ կատեգորիա</label>
                  <div class="col-sm-9">
                    <select class="form-select" v-model="form.f_a_q_category_id">
                            <option  disabled>Ընտրել ՀՏՀ կատեգորիա</option>
                            <option v-for="category in faqCategories" :key="category.id" :value = "category.id">{{category.title}}</option>
                    </select>
                    <small style = "color:red" v-if="errors.title">{{errors.f_a_q_category_id }}</small>
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
                    <br>
                    <small style = "color:red" v-if="errors.title">{{errors.content}}</small>
                  </div>
                </div>




                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-9">
                    <button class="btn btn-primary" @click="updateData">Պահպանել</button>
                  </div>
                </div>


               </div>
              <!-- End General Form Elements -->

            </div>
          </div>

        </div>


      </div>
    </section>

  </main>
</template>
