
<script setup>
import { onMounted, reactive, ref } from "vue"
import { useRouter, useRoute } from "vue-router"

const router = useRouter()
const route = useRoute()
let errors = ref([])

const form = reactive({
    title:"",
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
    getFaqCategory()

    })
const getFaqCategory = async () => {
    let response =await axios.get(`/api/faq-categories/${route.params.id}/edit`)
        .then((response)=>{
            console.log(response.data.faqCategory)
            form.title = response.data.faqCategory.title
            form.status = response.data.faqCategory.status
        })
}

 const updateData = () =>{

        axios.put(`/api/faq-categories/${route.params.id}`,form)
            .then((response)=>{
                router.push('/faq-categories')
                toast.fire({icon:"success",title:"ՀՏՀ բարեհաջող թարմացվել է"})
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


</script>
<template>
    <main id="main" class="main">

    <div class="pagetitle">
      <h1>ՀՏՀ կատեգորիա</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><router-link  to="/faq-categories">Ցանկ</router-link></li>

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
                        <input type="text" class="form-control" v-model="form.title">
                        <small style = "color:red" v-if="errors.title">{{errors.title}}</small>
                    </div>
                    </div>

                    <!-- <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Կարգավիճակ</label>
                                <div class="col-sm-8">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                            v-model="form.status"
                                        >

                                    </div>
                                </div>
                    </div> -->


                    <div class="row mb-3">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <button class="btn btn-primary" @click="updateData">Պահպանել</button>
                    </div>
                    </div>
               </div>


            </div>
          </div>

        </div>


      </div>
    </section>

  </main>
</template>
