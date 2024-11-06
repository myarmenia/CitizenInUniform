
<script setup>
import { reactive, ref, nextTick } from "vue"
import { useRouter } from "vue-router"
// import { useAuthStore } from '@/stores/auth'; // Your auth store


const router =useRouter()
const form = reactive({
    email:"",
    password:"",
})


const login = async () => {
  try {
    const response = await axios.post('/api/auth/login', form);
    localStorage.setItem('access_token', response.data.access_token);

    // Ensure the token is set before redirecting
    if (localStorage.getItem('access_token')) {
        console.log(555555)
      router.replace('/faq-categories');
    } else {
      console.error("Token was not stored successfully");
    }
  } catch (error) {
    errorMessage.value = "Invalid login credentials. Please try again.";
  }
};

</script>
    <template>
        <main id="main" class="main">
       <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <!-- <a href="index.html" class="logo d-flex align-items-center w-auto"> -->
                    <!-- <img src="/assets/img/logo.png'" alt=""> -->
                    <!-- <span class="d-none d-lg-block">

                    </span> -->
                    <!-- </a> -->
                </div>

                <div class="card mb-3">

                    <div class="card-body">

                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Մուտք համակարգ</h5>

                    </div>




                        <div class="col-12">
                        <label for="yourUsername" class="form-label">Էլ․հասցե</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="email" class="form-control"  v-model="form.email" value="" required autocomplete="email" autofocus>
                            <div class="invalid-feedback">Մուտքագրեք Ձեր Էլ․հասցեն</div>
                        </div>
                        </div>

                        <div class="col-12">
                        <label for="yourPassword" class="form-label">Գաղտնաբառ</label>
                        <input type="password" v-model="form.password" class="form-control" id="yourPassword" required>
                        <div class="invalid-feedback">Մուտքագրեք Ձեր գաղտնաբառը</div>
                        </div>



                        <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit" @click.prevent = "login">Մուտք</button>

                                        <a  class="btn btn-link" href="{{ route('password.request') }}">
                                            Մոռացել եք գաղտնաբառը?
                                        </a>

                        </div>



                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>
    </main>
</template>
