
<script setup>
import { onMounted, reactive, ref, onUnmounted, watch } from "vue"
import { useRouter, useRoute } from "vue-router"
import api, { initApi } from "../../api";
import { initTinyMCE } from '@/tinymce-init.js';

const router = useRouter()
const route = useRoute()
initApi(router);
let errors = ref([])
let userData = ref([]);
const allRoles = ref(false);
const selectedRoles=ref([])



const form = reactive({
    name:"",
    surname:"",
    email:"",
    phone:"",
    password:"",
    confirmPassword:"",
    roles:[]

})


onMounted(async () =>{
    getUserData()
    initTinyMCE();
    getAllRoles()

})

onUnmounted(() => {
    tinymce.remove();
});

watch(() => form.content, (newContent) => {
  const editor = tinymce.get('tiny-editor');
  if (editor && editor.getContent() !== newContent) {
    editor.setContent(newContent);
  }
});
const getAllRoles = () =>{

    let response =  api.value.get('/api/auth/all-roles')
    .then((response)=>{
        allRoles.value = response.data.roles
        console.log(allRoles.value)

    })
}


const getUserData = async () => {

    let response = api.value.get(`/api/auth/users/${route.params.id}`)
        .then((response)=>{

            let result = response.data.result
            console.log(result)

             form.name = result.name
             form.surname = result.surname
             form.phone = result.phone
             form.email = result.email
             form.roles = result.roles
            //  form.password = result.password
            //  form.confirmPassword = result.confirmPassword
             userData.value = result
            //  console.log(userData)
            //  console.log(form)

        })
}
const changeSelectedRole = ()=>{
    form.roles = selectedRoles.value
    console.log(55555556)
    console.log(form)

}

 const updateData = () =>{
    console.log(form)
    errors.value = {};


        api.value.put(`/api/auth/users/${route.params.id}`,form)
            .then((response)=>{
                router.push('/users')

                toast.fire({icon:"success",title:"Գործողությունը հաջողությամբ կատարված է"})
            })
            .catch((error) => {
                if (error.response && error.response.status === 422) {

                    const allErrors = error.response.data.errors;
                        for (const field in allErrors) {
                            console.log(allErrors.hasOwnProperty(field))
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
      <h1>ՀՏՀ  ենթակատեգորիա</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><router-link :to="{name:'faqCategorySubcategory.index'}">Ցանկ</router-link></li>
          <li class="breadcrumb-item active">Խմբագրել</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-10">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <!-- Խմբագրել -->
                </h5>

              <!-- General Form Elements -->
              <!-- <form> -->
               <div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Անուն</label>
                        <div class="col-sm-9">
                            <input type="text"
                                class="form-control"
                                v-model="form.name"
                                placeholder="Օգտատիրոջ անունը"
                                    >

                            <div  v-if="errors.name" class="mb-3 row justify-content-start">
                                <div class="col-sm-9 text-danger fts-14">{{ errors.name }}
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">Ազգանուն</label>
                    <div class="col-sm-9">
                        <input type="text"
                            class="form-control"
                            v-model="form.surname"
                            placeholder="Օգտատիրոջ ազգանունը"
                                >

                        <div  v-if="errors.surname" class="mb-3 row justify-content-start">
                            <div class="col-sm-9 text-danger fts-14">{{ errors.surname }}
                            </div>
                        </div>


                    </div>

                    </div>
                    <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">Հեռախոսահամար</label>
                    <div class="col-sm-9">
                        <input type="text"
                            class="form-control"
                            v-model="form.phone"
                            placeholder="+374980000"
                            >
                        <div  v-if="errors.phone" class="mb-3 row justify-content-start">
                            <div class="col-sm-9 text-danger fts-14">{{ errors.phone }}
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
                        <div v-if="errors.password" class="mb-3 row justify-content-start">
                            <div class="col-sm-9 text-danger fts-14">{{ errors.password}}
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
                            <select  class="form-control"   multiple="multiple"  v-model="form.roles"  >
                                <option v-for ="(label,value) in allRoles"
                                        :value = "value"
                                        :key = "value"

                                         >
                                        {{ label }}
                                </option>
                            </select>

                            <!-- <div  v-if="errors.roles" class="mb-3 row justify-content-start">
                                <div class="col-sm-9 text-danger fts-14">{{ errors.roles }}
                                </div>
                            </div> -->

                        </div>

                    </div>
                    <div class="row mb-3">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                    <button class="btn btn-primary" @click="updateData">Պահպանել</button>
                  </div>
                </div>



               </div>
              <!-- End General Form Elements -->

            </div>
          </div>

        </div>


      </div>
    </section>

  </main>
</template>
