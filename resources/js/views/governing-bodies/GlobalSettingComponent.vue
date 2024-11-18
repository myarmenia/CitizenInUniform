<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  initialGlobalSettings: {
    type: Array,
    required: true,
  }

});


const emit = defineEmits()
const globalSettings = ref({ ...props.initialGlobalSettings }); // Создаём копию объекта


watch(
  () => props.initialGlobalSettings,
  (newValue) => {
    globalSettings.value = { ...newValue };
  },
  { immediate: true }
);

function onStatusChange(event) {
  const settingType = event.target.dataset.type; // Используем data-type для идентификации
  if (settingType === 'email') {
    globalSettings.value.email = event.target.checked;
  } else if (settingType === 'phone') {
    globalSettings.value.phone = event.target.checked;
  }
}


function saveData() {
    emit('save', globalSettings.value);

}
</script>


<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-10">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Խմբագրել</h5>

                            <div class="row mb-2 ">

                                <div class="col-sm-6 d-flex justify-content-start align-items-center">
                                    <label for="email" class="col-sm-6 col-form-label">Նամակագրության գործառույթ </label>
                                    <div class="form-check form-switch mx-2">
                                        <input class="form-check-input change_status" type="checkbox" role="switch"
                                            :checked="globalSettings.email"
                                            data-type="email"
                                            @change="onStatusChange" >
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 ">

                                <div class="col-sm-6 d-flex justify-content-start align-items-center">
                                    <label for="email" class="col-sm-6 col-form-label">Հեռախոսազանգերի գործառույթ </label>
                                    <div class="form-check form-switch mx-2">
                                        <input class="form-check-input change_status" type="checkbox" role="switch"
                                            :checked="globalSettings.phone"
                                            data-type="phone"
                                            @change="onStatusChange" >
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-9 d-flex justify-content-start">
                                    <button type="submit" class="btn btn-primary" @click="saveData">Պահպանել</button>

                                    <button @click="$emit('cancel')" class="btn btn-secondary mx-3">Չեղարկել</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
