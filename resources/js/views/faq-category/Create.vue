
<script setup>
import { reactive, ref } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()
let errors = ref([])

const form = reactive({
    title:"",
})

const handleSave = () =>{
    axios.post('/api/create-faq-category',form)
    .then((response)=>{
        router.push('/faq-categories')
        toast.fire({icon:"success",title:"ՀՏՀ բարեհաջող ավելացվել է"})
    })
     .catch((error) => {
                // if(error.response.status ===422){
                //     console.log(error.response.data.errors)
                //     errors.value = error.response.data.errors
                // }
                if (error.response && error.response.status === 422) {
            // Capture validation errors and extract the first message for each field
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
      <h1>Form Elements</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Ստեղծել</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <!-- General Form Elements -->
            </h5>

              <!-- General Form Elements -->
              <!-- <form> -->
               <div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Վերնագիր</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="form.title">
                    <small style = "color:red" v-if="errors.title">{{errors.title}}</small>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">
                    <!-- Submit Button -->
                </label>
                  <div class="col-sm-10">
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
