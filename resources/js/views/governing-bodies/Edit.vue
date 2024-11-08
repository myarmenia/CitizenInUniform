<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, onMounted } from  "vue"
import api, { initApi } from "../../api";
import EmailComponent from './EmailComponent.vue';
import PhoneComponent from './PhoneComponent.vue';

const router = useRouter()
const route = useRoute()
const selectedComponent = ref(null);
const email = ref({ text: '', status: false });
const phones = ref([]);

let governingBody = ref([])
let errors = ref([])

initApi(router);

function showComponent(componentName) {
  selectedComponent.value = componentName;
}

function hideComponent() {
    selectedComponent.value = null;
}


onMounted(async () => {
    getGoverningBody()
})


const getGoverningBody = async () => {
    let response = api.value.get( `/api/auth/governing-bodies/${route.params.id}`)
    .then((response) => {
        let result =  response.data.result

        governingBody.value = result

        result.infos.forEach(info => {
            if (info.type === 'email') {
                email.value = { text: info.text, status: info.status || false };
            }
            else{
                phones.value.push({ text: info.text, status: info.status || false });
            }
        });

    })
}

function updateEmail(newEmail) {
    email.value = newEmail; // обновляем email
    hideComponent();
}

function updatePhoneList(newPhoneList) {
    phones.value = newPhoneList;
    hideComponent();
}


function handleSave(type, updatedValue) {

  console.log('Type:', type);
  console.log('Updated Value:', updatedValue);

  const data = {
        governing_body_id: route.params.id,
        type: type,
        data: updatedValue,

    };

    api.value.put(`/api/auth/governing-bodies/${route.params.id}`, data)
      .then((response) => {

            toast.fire({icon: 'success', title: 'Գործողությունը հաջողությամբ կատարված է'})

        })
        .catch((error) => {
            errors.value = []
            if(error.response.status === 422){
                errors.value = error.response.data.errors
            }
        })
    console.log(data)

}




</script>


<template>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Պետական կառավարման մարմիններ</h1>
            <nav>
                <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item ">
                        <router-link class="dropdown-item" :to="{name: 'categories.index' }"> Ցանկ</router-link>
                    </li> -->
                    <li class="breadcrumb-item active">Խմբագրել</li>
                </ol>
            </nav>
        </div>

        <section class="section contact">
            <div class="row gy-4">
                <div class="col-xl-10">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="info-box card">
                                <img :src="governingBody.path" class="image">
                                <h3 >{{governingBody.name}}</h3>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info-box card">
                                <div class="d-flex justify-content-between">
                                    <i class="bi bi-envelope"></i>
                                    <i class="bi bi-pencil" @click="showComponent('emailComponent')"></i>
                                </div>

                                <h3 >Էլ․ փոստ</h3>
                                 <p ></p>
                                 <p v-if="email">{{ email.text }}</p>
                                 <p v-else>-----</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info-box card">
                                <div class="d-flex justify-content-between">
                                    <i class="bi bi-telephone"></i>
                                    <i class="bi bi-pencil" @click="showComponent('phoneComponent')"></i>
                                </div>
                                <h3 >Հեռախոս</h3>
                                <p v-if="phones.length > 0" v-for="phone in phones">{{phone.text}}</p>
                                <p v-else>-----</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- <div class="col-xl-6">
                <div class="card p-4">
                    <form action="forms/contact.php" method="post" class="php-email-form">
                    <div class="row gy-4">

                        <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                        </div>

                        <div class="col-md-6 ">
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                        </div>

                        <div class="col-md-12">
                        <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                        </div>

                        <div class="col-md-12">
                        <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                        </div>

                        <div class="col-md-12 text-center">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>

                        <button type="submit">Send Message</button>
                        </div>

                    </div>
                    </form>
                </div>

                </div> -->

            </div>

        </section>

        <div v-if="selectedComponent === 'emailComponent'">
            <EmailComponent :initialEmail="email" @save="(updatedValue) => handleSave('email', updatedValue)" @cancel="hideComponent" />
        </div>
        <div v-else-if="selectedComponent === 'phoneComponent'" >
            <PhoneComponent :initialPhoneList="phones"@save="(updatedValue) => handleSave('phone', updatedValue)" @cancel="hideComponent" />
        </div>

    </main><!-- End #main -->

</template>
<style scoped>

.image{
  max-width: 40px;
  max-height: 40px;
  margin-right: 10px;
}

</style>
