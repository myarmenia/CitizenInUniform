
<script setup>
import { reactive, ref } from "vue"
import { useRouter } from "vue-router"
import api, { initApi } from "../../api";

const router = useRouter()
initApi(router); // Initialize the API with the router
let errors = ref([])

const form = reactive({
    title:"",
})

const handleSave = () =>{
    errors.value = {};
    api.value.post('/api/auth/create-faq-category',form)
    .then((response)=>{
        console.log(response)
        // router.push('/faq-categories')
        // toast.fire({icon:"success",title:"Գործողությունը հաջողությամբ կատարված է"})
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

          <li class="breadcrumb-item active">Ստեղծել</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <!-- Ստեղծել նոր բաժին -->
                </h5>

               <div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">ՀՏՀ կատեգորիա</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.title">
                            <small style = "color:red" v-if="errors.title">{{errors.title}}</small>
                        </div>
                    </div>

                <div class="row mb-2">
                  <label class="col-sm-2 col-form-label">

                </label>
                  <div class="col-sm-9">
                    <button class="btn btn-primary" @click="handleSave">Ստեղծել</button>
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
