<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import api, { initApi } from "../../api";

const router =useRouter()
initApi(router);
const errorMessage=ref("")
let errors = ref([])

const form = reactive({
    old_password:'',
    new_password:'',
    new_password_confirmation: '',
})

const changePassword = async () => {
  errors.value = {};
  try {
   let response = await api.value.post('/api/auth/change-password', form);
   if(response.data.message=="Successfully logged out"){
     localStorage.removeItem('access_token');
    window.location.href='users/login'

}


  } catch (error) {
        if (error.response && error.response.status === 422) {
            const allErrors = error.response.data.errors;
            console.log(allErrors)
            for (const field in allErrors) {
                if (allErrors.hasOwnProperty(field)) {
                    errors.value[field] = allErrors[field][0]; // Get only the first error message
                }
            }
        }
  }
};


</script>
<template>
     <main id="main" class="main">
        <div class="pagetitle">
            <h1>Գաղտնաբառի փոփոխություն</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">
                        <!-- Ցանկ -->
                    </li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <div>

                                <div class="row mb-3">
                                <label for="old_password" class="col-md-4 col-lg-3 col-form-label">Ընթացիկ գաղտնաբառ</label>
                                <div class="col-md-8 col-lg-9">
                                    <input  type = "password"
                                            class = "form-control"
                                            v-model ="form.old_password"
                                            >
                                        <small style = "color:red" v-if="errors.old_password">{{ errors.old_password }}</small>
                                </div>
                                </div>

                                <div class="row mb-3">
                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Նոր գաղտնաբառ</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="password"
                                        class="form-control"
                                        v-model="form.new_password">
                                    <small style = "color:red" v-if="errors.new_password">{{errors.new_password}}</small>
                                </div>
                                </div>

                                <div class="row mb-3">
                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Հաստատել նոր գաղտնաբառը</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type = "password"
                                           class = "form-control"
                                           v-model = "form.new_password_confirmation"
                                            >
                                 <small style = "color:red" v-if="errors.new_password_confirmation">{{errors.new_password_confirmation}}</small>
                                </div>
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary" @click.prevent="changePassword">Պահպանել</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </main>

</template>
