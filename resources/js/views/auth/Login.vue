
<script setup>
import { reactive, ref, nextTick } from "vue"
import { useRouter } from "vue-router"


const router =useRouter()
let errors = ref([])
const form = reactive({
    email:"",
    password:"",
})
const  errorMessage=ref(false);

const login = async () => {
    errors.value={}
  try {
    const response = await axios.post('/api/auth/login', form);
    localStorage.setItem('access_token', response.data.access_token);


    if (localStorage.getItem('access_token')) {

        window.location.href = '/welcome';

    } else {
      console.error("Token was not stored successfully");
    }
  } catch (error) {

        if (error.response && error.response.status === 422) {

            const allErrors = error.response.data.errors;
            for (const field in allErrors) {
                if (allErrors.hasOwnProperty(field)) {
                    errors.value[field] = allErrors[field][0];
                }
            }
        }
    }
};

</script>
    <template>
        <main >
       <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Մուտք համակարգ</h5>
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

                                        <input type="password" v-model="form.password" class="form-control" id="yourPassword" required @keyup.enter="login">
                                    </div>
                                    <div  v-if="errors.password" class="mb-3 row justify-content-start">
                                        <div class="col-sm-9 text-danger fts-14">{{ errors.password }}</div>
                                    </div>


                                </div>
                                <div class="col-12" @keydown.enter="login">
                                <button class="btn btn-primary w-100" @click.prevent = "login">Մուտք</button>

                                    <router-link class="btn btn-link" to="password/reset">
                                        Մոռացել եք գաղտնաբառը?
                                    </router-link>

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
