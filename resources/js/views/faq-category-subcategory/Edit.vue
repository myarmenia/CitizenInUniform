
<script setup>
import { onMounted, reactive, ref } from "vue"
import { useRouter, useRoute } from "vue-router"

const router = useRouter()
const route = useRoute()
let errors = ref([])

const form = reactive({
    title:"",
    content:"",
})

// const handleSave = () =>{
//     axios.post('/api/create-faq-category',form)
//     .then((response)=>{
//         router.push('/faq-categories')
//         toast.fire({icon:"success",title:"ՀՏՀ բարեհաջող ավելացվել է"})
//     })
//      .catch((error) => {
//                 // if(error.response.status ===422){
//                 //     console.log(error.response.data.errors)
//                 //     errors.value = error.response.data.errors
//                 // }
//                 if (error.response && error.response.status === 422) {
//             // Capture validation errors and extract the first message for each field
//             const allErrors = error.response.data.errors;
//             for (const field in allErrors) {
//                 if (allErrors.hasOwnProperty(field)) {
//                     errors.value[field] = allErrors[field][0]; // Get only the first error message
//                 }
//             }
//         }

//             })

// }
onMounted(async () =>{
    getFaqCategorySubcategory()

    })
const getFaqCategorySubcategory = async () => {

    let response =await axios.get(`/api/faq-category-subcategory/${route.params.id}`)
        .then((response)=>{
            console.log(response.data.data)
            form.title = response.data.data.faqCategoryubcategory.title
             form.content = response.data.data.faqCategoryubcategory.content
            // form.status = response.data.faqCategory.status
        })
}

//  const updateData = () =>{

//         axios.put(`/api/faq-categories/${route.params.id}`,form)
//             .then((response)=>{

//                 toast.fire({icon:"success",title:"ՀՏՀ բարեհաջող թարմացվել է"})
//             })
//             .catch((error) => {
//                 if(error.response.status ===422){

//                     errors.value = error.response.data.errors
//                 }

//             })
//     }


</script>
<template>
    <main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Elements</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Խմբագրել</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <!-- Խմբագրել -->
                </h5>

              <!-- General Form Elements -->
              <!-- <form> -->
               <div>
                 <div class="row mb-3">
                  <label for="inputText" class="col-sm-3 col-form-label">ՀՏՀ կատեգորիա</label>
                  <div class="col-sm-9">
                    <select class="form-select" aria-label="Default select example" v-model="selectedCategory" @change="handleSelectionChange">
                            <option value='' disabled >Ընտրել ՀՏՀ կատեգորիա </option>
                            <option v-for="category in faqCategories" :key="category.id" :value = "category.id">{{category.title}}</option>
                    </select>
                    <small style = "color:red" v-if="errors.title">{{errors.title}}</small>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-3 col-form-label">Վերնագիր</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" v-model="form.title">
                    <small style = "color:red" v-if="errors.title">{{errors.title}}</small>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-3 col-form-label">Բովանդակություն</label>
                  <div class="col-sm-9">
                    <textarea class="tinymce-editor"  id="tiny-editor" v-model="form.content"></textarea>

                    <small style = "color:red" v-if="errors.title">{{errors.content}}</small>
                  </div>
                </div>




                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label"></label>
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
