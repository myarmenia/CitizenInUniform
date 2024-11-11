<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    initialPhoneList: {
        type: Array,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['save', 'cancel']);


function createPhoneObject(phone) {
  return {
    phone: phone.text,
    isRemovable: phone.isRemovable || false,
    status: !!phone.status
  };
}


const phoneList = ref(
  Array.isArray(props.initialPhoneList)
    ? props.initialPhoneList.map(createPhoneObject)
    : []
);


watch(() => props.initialPhoneList, (newVal) => {
  phoneList.value = Array.isArray(newVal) ? newVal.map(createPhoneObject) : [];
});


function addPhone() {
  phoneList.value.push({ phone: '', isRemovable: true, status: false }); // используем status
}

const getPhoneErrors = (phoneIndex) => {
  if (props.errors && props.errors[`data.${phoneIndex}.phone`]) {
    return props.errors[`data.${phoneIndex}.phone`];
  }
  return [];
};


function removePhone(index) {
  if (phoneList.value[index].isRemovable) {
    phoneList.value.splice(index, 1);
  }
}


function save() {
  const phonesToSave = phoneList.value.map(({ phone, status }) => ({ phone, status }));
  emit('save', phonesToSave);
}
</script>
<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-10">
                <div class="card">

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Խմբագրել</h5>
                            <button type="button" class="btn btn-primary" @click="addPhone">Ավելացնել համար</button>
                        </div>
                        <div v-for="(phoneItem, index) in phoneList" :key="index" class="mb-2">
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-3 col-form-label"> Հեռախեսահամար</label>
                                <div class="col-sm-9 d-flex justify-content-between">
                                    <div class="w-100">
                                        <input type="text" class="form-control" v-model="phoneItem.phone">

                                        <div class="mb-3 " v-if="getPhoneErrors(index).length > 0">
                                            <p class="col-sm-10 text-danger fs-6" v-for="(error, errorIndex) in getPhoneErrors(index)" :key="errorIndex">{{ error }}</p>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch mx-2">
                                        <!-- Использование v-model для двусторонней привязки -->
                                        <input
                                        class="form-check-input change_status"
                                        type="checkbox"
                                        v-model="phoneItem.status"
                                            :checked="phoneItem.status"
                                        />
                                    </div>
                                    <span class="deleteFile" @click="removePhone(index)" v-if="phoneItem && phoneItem.isRemovable">
                                        <i class="bx bx-trash me-1 ml-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9 d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary" @click="save">Պահպանել</button>
                                <button @click="$emit('cancel')" class="btn btn-secondary">Չեղարկել</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
