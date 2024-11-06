
<script setup>
import { onMounted, reactive, ref } from "vue"
import { useRouter, useRoute } from "vue-router"
import api, { initApi } from "../../api";

const router = useRouter()
initApi(router); // Initialize the API with the router
const route = useRoute()
let errors = ref([])

const form = reactive({
    title:"",
})

onMounted(async () =>{
    getFaqCategory()

    })
const getFaqCategory = async () => {
    let response =await api.value.get(`/api/auth/faq-categories/${route.params.id}/edit`)
        .then((response)=>{
            console.log(response.data.faqCategory)
            form.title = response.data.faqCategory.title
            form.status = response.data.faqCategory.status
        })
}

 const updateData = () =>{
    errors.value = {};

        api.value.put(`/api/auth/faq-categories/${route.params.id}`,form)
            .then((response)=>{
                router.push('/faq-categories')
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
        <div class="col-lg-8">

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
                    <label class="col-sm-2 col-form-label"></label>
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
