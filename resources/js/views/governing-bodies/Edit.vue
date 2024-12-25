<script setup>
import { useRouter, useRoute } from "vue-router"
import { ref, onMounted, watch } from  "vue"
import api, { initApi } from "../../api";
import EmailComponent from './EmailComponent.vue';
import PhoneComponent from './PhoneComponent.vue';
import GlobalSettingComponent from './GlobalSettingComponent.vue';
import {me} from "../../me";

const router = useRouter()
const route = useRoute()
const selectedComponent = ref(null);
const email = ref({ text: '', status: false });
const showEmail = ref({ text: '', status: false });
const phones = ref([]);
const globalSettings = ref([])
const {userMe} = me(router)

let governingBody = ref([])
let errors = ref([])

initApi(router);

function showComponent(componentName) {
    errors.value = [];
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

        errors.value = [];
        governingBody.value = [];
        email.value = { text: '', status: false };
        showEmail.value = { text: '', status: false };
        phones.value = [];

        let result =  response.data.result

        governingBody.value = result
        globalSettings.value = { email: result.email, phone: result.phone};

        result.infos.forEach(info => {
            if (info.type === 'email') {
                email.value = { text: info.text, status: info.status || false };
                showEmail.value = { text: info.text, status: info.status || false };

            }
            else{
                phones.value.push({ text: info.text, status: info.status || false });
            }
        });

    })
}


watch(() => route.params.id,  // Отслеживаем изменение параметра ID в маршруте
    (newId) => {
        if (newId) {
            getGoverningBody();  // Вызов функции при изменении ID
        }
    },
    { immediate: true }  // Это обеспечит вызов функции при монтировании компонента
);

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

            getGoverningBody();
            toast.fire({icon: 'success', title: 'Գործողությունը հաջողությամբ կատարված է'})

        })
        .catch((error) => {
            errors.value = []

            if(error.response.status === 422){
                errors.value = error.response.data.errors
            }

        })

}


</script>


<template>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Պետական կառավարման մարմիններ</h1>
            <nav>
                <ol class="breadcrumb">

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
                                 <div class="d-flex justify-content-between">
                                    <img :src="governingBody.path" class="image">
                                    <button v-if="userMe.roles?.some(role => role.name != 'super_admin')"
                                        class="btn btn-primary" @click="showComponent('globalSettingComponent')"><i class="bi bi-pencil cwhith fts-20" ></i></button>
                                </div>
                                <h3 >{{governingBody.name}}</h3>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info-box card">
                                <div class="d-flex justify-content-between">
                                    <i class="bi bi-envelope"></i>
                                    <button v-if="userMe.roles?.some(role => role.name != 'super_admin')"
                                        class="btn btn-primary" @click="showComponent('emailComponent')"><i class="bi bi-pencil cwhith fts-20" ></i></button>
                                </div>

                                <h3 >Էլ․ փոստ</h3>
                                 <p ></p>
                                 <p v-if="showEmail.text && showEmail.status"><span v-if="showEmail.status"> {{showEmail.text}}</span></p>
                                 <p v-else>-----</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info-box card">
                                <div class="d-flex justify-content-between">
                                    <i class="bi bi-telephone"></i>
                                    <button v-if="userMe.roles?.some(role => role.name != 'super_admin')"
                                        class="btn btn-primary" @click="showComponent('phoneComponent')"><i class="bi bi-pencil cwhith fts-20" ></i></button>
                                </div>
                                <h3 >Հեռախոս</h3>
                                <p v-if="phones.length > 0 && phones.some(phone => phone.status)" v-for="phone in phones"><span v-if="phone.status"> {{phone.text}}</span> </p>
                                <p v-else>-----</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>

        <div v-if="selectedComponent === 'globalSettingComponent'" >
            <GlobalSettingComponent :initialGlobalSettings="globalSettings" :errors="errors" @save="(updatedValue) => handleSave('globalSettings', updatedValue)" @cancel="hideComponent" />
        </div>
        <div v-else-if="selectedComponent === 'emailComponent'">
            <EmailComponent :initialEmail="email" :errors="errors"  @save="(updatedValue) => handleSave('email', updatedValue)" @cancel="hideComponent" />
        </div>
        <div v-else-if="selectedComponent === 'phoneComponent'" >
            <PhoneComponent :initialPhoneList="phones" :errors="errors" @save="(updatedValue) => handleSave('phone', updatedValue)" @cancel="hideComponent" />
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
