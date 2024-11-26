
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


        toast.fire({icon:"success",title:messages.value})
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
                                    <h5 class="card-title text-center pb-0 fs-4">Գաղտնաբառի վերականգնում</h5>
                                </div>
                                <div  class="row g-3 needs-validation d-flex justify-content-center"  novalidate>
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

                                    <div >
                                        <button  @click.prevent="sendResetLink" class="btn btn-primary mt-3">
                                            Ուղարկեք վերականգնման հղումը
                                        </button>
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
