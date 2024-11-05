<script setup>
import { useRouter } from "vue-router"
import { ref, reactive, onMounted, onUnmounted } from  "vue"

const router = useRouter()

let errors = ref([])
let settings = ref([])
const selectedSetting = ref('Ընտրել ծանուցման տեսկը');


const form = reactive({
    setting_id: '',
    title: '',
    content: '',
    errorMessage: ''
})

onMounted(async () => {
    getSettings()

})



const getSettings = async () => {
    let response = await axios.get ( '/api/settings')
    .then((response) => {

       settings.value = response.data.result

    })
}


const handleSelectionChange = () => {
    form.setting_id = selectedSetting.value

}


const dataSave = async () => {
    try {
        await axios.post('/api/notifications', form)

        router.push('/notifications')
        toast.fire({icon: 'success', title: 'Գործողությունը հաջողությամբ կատարված է'})
    } catch (error) {
            errors.value = error.response.data.errors

    }
}

</script>


<template>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Ծանուցումներ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">
                        <router-link class="dropdown-item" :to="{name: 'notifications.index' }"> Ցանկ</router-link>
                    </li>
                    <li class="breadcrumb-item active">Ստեղծել</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Ստեղծել նոր Ծանուցում </h5>

                                <div class="row mb-3">
                                    <label for="title" class="col-sm-3 col-form-label">Տեսակ </label>
                                    <div class="col-sm-9">

                                        <select class="form-select"  v-model="selectedSetting"  @change="handleSelectionChange" >
                                                <option disabled selected>Ընտրել ծանուցման տեսկը </option>
                                                <option v-for="setting in settings" :key="setting.id" :value="setting.id">{{setting.name}}</option>
                                        </select>

                                        <div class="mb-3 row " v-if="errors.setting_id">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorSettingId in errors.setting_id">{{ errorSettingId }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="title" class="col-sm-3 col-form-label">Վերնագիր </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="form.title" id="title"
                                            placeholder="Վերնագիր" >
                                        <div class="mb-3 row " v-if="errors.title">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorTitle in errors.title">{{ errorTitle }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="content" class="col-sm-3 col-form-label">Բովանդակություն </label>
                                    <div class="col-sm-9">

                                         <textarea class="form-control"  v-model="form.content"></textarea>

                                        <div class="mb-3 row " v-if="errors.content">
                                            <p class="col-sm-10 text-danger fs-6" v-for="errorContent in errors.content">{{ errorContent }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" @click="dataSave">Ստեղծել</button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

</template>
