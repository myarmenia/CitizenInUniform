
<script setup>
import { ref, reactive  } from 'vue';
import { useRouter } from "vue-router"
import axios from 'axios';
// method post
// password/email name email
// Auth\ForgotPasswordController@sendResetLinkEmail

const messages= ref('')
let errors = ref([])
const form = reactive({
    email:"",
})



const sendResetLink = () =>{

console.log(form)
    errors.value = {};
    
    axios.post('/api/password/forgot',form)
    .then((response)=>{
        console.log(response.data.message)
        messages.value=response.data.message

        // router.push('/faq-category-subcategory')
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
     <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <!-- <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="{{ asset('assets/img/logo.png') }}" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a> -->
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                        <div v-if="messages" class="alert alert-success" role="alert">
                            {{ messages }}
                        </div>


                  <div class="pt-4 pb-2">
                    <h6 class="card-title text-center pb-0 fs-5">Գաղտնաբառի վերականգնում </h6>

                  </div>
                  <!-- <form  class="row g-3 needs-validation" method="POST" action="" novalidate> -->

                    <div class="col-12">

                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email"  class="form-control"
                               placeholder="Մուտքագրեք Ձեր էլ․ հասցեն"

                               v-model="form.email"

                               >
                        <div class="invalid-feedback">Մուտքագրեք Ձեր Էլ․հասցեն</div>
                      </div>
                    </div>
                    <div  v-if="errors.email" class="mb-3 row justify-content-start">
                        <div class="col-sm-9 text-danger fts-14">{{ errors.email }}</div>
                                        </div>
                    <div class="col-12 d-flex justify-content-center">

                                <button  @click.prevent="sendResetLink" class="btn btn-primary mt-3">
                                    Ուղարկեք վերականգնման հղումը
                                </button>

                    </div>
                  <!-- </form> -->

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

</template>
