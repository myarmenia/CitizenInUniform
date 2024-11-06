
<script setup>
import { onMounted, reactive, ref } from "vue"
import { useRouter } from "vue-router"
import api, { initApi } from "../../api";

const router = useRouter()
initApi(router); // Initialize the API with the router
let errors = ref([])

const form = reactive({
    name:"",
    email:"",
    password:"",
    confirmPassword:""

})
onMounted(async () =>{
    getAllRoles()
})
const allRoles = ref(false);
const getAllRoles = () =>{

    let response =  api.value.get('/api/auth/all-roles')
        .then((response)=>{
            console.log(response.data)
            console.log(response.data.faqCategories)
            allRoles.value = response.data.faqCategories


        })
}

const handleSave = () =>{

    errors.value = {};
    api.value.post('/api/auth/users',form)
    .then((response)=>{

        router.push('/users')
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
      <h1>Օգտատերեր</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><router-link  to="/users">Ցանկ</router-link></li>

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

                    <label for="inputText" class="col-sm-3 col-form-label">Անուն</label>
                    <div class="col-sm-9">
                        <input type="text"
                               class="form-control"
                               v-model="form.name"
                               placeholder="Աշխատակցի անունը"
                                >

                        <div  v-if="errors.name" class="mb-3 row justify-content-start">
                            <div class="col-sm-9 text-danger fts-14">{{ errors.name }}
                            </div>
                        </div>


                    </div>

                    </div>
                    <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Էլ.հասցե</label>
                    <div class="col-sm-9">
                        <input type="email"
                               class="form-control"
                               placeholder="example@gmail.com"
                                v-model="form.email"
                                >
                        <div v-f="errors.email" class="mb-3 row justify-content-start">
                            <div class="col-sm-9 text-danger fts-14">{{ errors.email }}
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="row mb-3">
                    <label for="inputEmail"  class="col-sm-3 col-form-label">Գաղտնաբառ</label>
                    <div class="col-sm-9">
                        <input type="password"
                               class="form-control"
                               placeholder="Password"
                               v-model="form.password"
                               >
                        <div v-if="errors.passwor" class="mb-3 row justify-content-start">
                            <div class="col-sm-9 text-danger fts-14">{{ errors.passwor}}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Հաստատել գաղտնաբառը</label>
                    <div class="col-sm-9">
                        <input type="password"
                             v-model="form.confirmPassword" class="form-control" placeholder="Confirm Password">
                    </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Դերեր</label>
                        <div class="col-sm-9">
                            <select name = "roles[]" class="form-control" id="selectedRole" multiple="multiple">
                                <!-- @foreach ($roles as $value => $label)

                                    <option v-for ="" value = "{{ $value }}" {{ in_array($value, old('roles', [])) ? 'selected' : '' }} >
                                        {{ $label }}
                                    </option>
                                @endforeach -->
                            </select>

                            <div  v-if="errors.roles"class="mb-3 row justify-content-start">
                                <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row mb-3" id="loginBtn">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" @click="handleSave">Ստեղծել</button>
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
