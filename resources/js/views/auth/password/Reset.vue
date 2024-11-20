<script setup>
import { ref, reactive, onMounted  } from 'vue';
import { useRouter, useRoute } from "vue-router"
import axios from 'axios';
// method post
// password/email name email
// Auth\ForgotPasswordController@sendResetLinkEmail

const messages= ref('')
let errors = ref([])
const route=useRoute()
const form = reactive({
    email:'',
    token:'',
    new_password:'',
    new_password_confirmation: '',



})
onMounted(async () =>{
    form.token = route.query.token
    form.email = route.query.email
    console.log()
})

const confirmPassword = () =>{

console.log(form)
    errors.value = {};


    axios.post('/api/confirm-password-changes',form)
    .then((response)=>{
        console.log(response.data.message)
        messages.value=response.data.message

        localStorage.removeItem('access_token');
        window.location.href='login'
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

                    <!-- <div v-for="(error, index) in errors" class="alert alert-danger" role="alert">

                        {{ error }}
                    </div> -->
                   

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Գաղտնաբառի փոփոխում</h5>

                  </div>
                  <!-- <form  class="row g-3 needs-validation" method="POST" action="{{ route('password.update') }}" > -->

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Էլ․հասցե</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" v-model="form.email">
                        <div class="invalid-feedback">Մուտքագրեք Ձեր Էլ․հասցեն</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Գաղտնաբառ</label>
                      <input id="password" type="password" v-model="form.new_password"  class="form-control @error('password') is-invalid @enderror"  >
                      <!-- @error('password') -->
                                    <span  class="invalid-feedback" role="alert">
                                        <strong>
                                            <!-- {{ $message }} -->
                                        </strong>
                                    </span>
                                <!-- @enderror -->

                    </div>

                    <div class="col-12">
                        <label for="password-confirm" class="form-label">Գաղտնաբառի հաստատում</label>
                        <input type="password"  v-model ="form.new_password_confirmationnew_password_confirmation" class="form-control" id="password-confirm" required>
                        <div  v-if="errors.new_password_confirmation" class="mb-3 row justify-content-start">
                            <div class="col-sm-9 text-danger fts-14">{{ errors.new_password_confirmation }}</div>
                        </div>

                      </div>
                      <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button @click.prevent="confirmPassword"class="btn btn-primary mt-2">
                                Հաստատել
                            </button>


                        </div>
                    </div>




                  <!-- </form> -->

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</template>
