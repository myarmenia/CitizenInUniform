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
    password:'',
    password_confirmation: '',



})
onMounted(async () =>{
    form.token = route.query.token
    form.email = route.query.email
    console.log()
})

const confirmPassword = () =>{

console.log(form)

    errors.value = {};


    axios.put('/api/password/reset',form)
    .then((response)=>{
        console.log(response.data.message)
        messages.value=response.data.message

        localStorage.removeItem('access_token');
        window.location.href='/login'
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

     <main>
       <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Գաղտնաբառի փոփոխում</h5>
                            </div>
                            <div  class="row g-3 needs-validation"  novalidate>
                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Էլ․հասցե</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input type="email" v-model="form.email" class="form-control"   required autocomplete="email" autofocus>
                                    </div>
                                    <div  v-if="errors.email" class="mb-3 row justify-content-start">
                                        <div class="col-sm-9 text-danger fts-14">{{ errors.email }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Գաղտնաբառ</label>
                                    <div class="input-group has-validation">

                                        <input type="password" v-model="form.password" class="form-control" id="yourPassword" required>
                                    </div>
                                    <div  v-if="errors.password" class="mb-3 row justify-content-start">
                                        <div class="col-sm-9 text-danger fts-14">{{ errors.password }}</div>
                                    </div>


                                </div>
                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Գաղտնաբառի հաստատում</label>
                                    <div class="input-group has-validation">

                                        <input type="password" v-model="form.password_confirmation" class="form-control" id="yourPassword" required>
                                    </div>
                                    <div  v-if="errors.password" class="mb-3 row justify-content-start">
                                        <div class="col-sm-9 text-danger fts-14">{{ errors.password}}</div>
                                    </div>


                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" @click.prevent="confirmPassword">Հաստատել</button>
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
