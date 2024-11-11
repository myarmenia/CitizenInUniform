<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import api, { initApi } from "../../api";

const router =useRouter()
initApi(router);
const errorMessage=ref("")
let errors = ref([])

const form = reactive({
    currentPassword:'',
    newPassword:'',
    confirmNewPassword: '',
})

const changePassword = async () => {
  errors.value = {};
  try {
   let response = await api.value.post('/api/auth/change-password', form);
    console.log(response)

  } catch (error) {
        if (error.response && error.response.status === 422) {
            const allErrors = error.response.data.errors;
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
                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Ընթացիկ գաղտնաբառ</label>
                                <div class="col-md-8 col-lg-9">
                                    <input  type = "password"
                                            class = "form-control"
                                            v-model = "form.currentPassword"
                                            >
                                        <small style = "color:red" v-if="errors.currentPassword">{{ errors.currentPassword }}</small>
                                </div>
                                </div>

                                <div class="row mb-3">
                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Նոր գաղտնաբառ</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="password"
                                        class="form-control"
                                        v-model="form.newPassword">
                                    <small style = "color:red" v-if="errors.newPassword">{{errors.newPassword}}</small>
                                </div>
                                </div>

                                <div class="row mb-3">
                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Հաստատել նոր գաղտնաբառը</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type = "password"
                                           class = "form-control"
                                           v-model = "form.confirmNewPassword"
                                            >
                                 <small style = "color:red" v-if="errors.confirmNewPassword">{{errors.confirmNewPassword}}</small>
                                </div>
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary" @click.prevent="changePassword" >Փոփոխել գաղտնաբառը</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </main>

</template>
