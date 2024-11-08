<script setup>
import { ref, watch, toRef } from 'vue';

const props = defineProps(['initialPhoneList']);
const emit = defineEmits(['save', 'cancel']);

// Функция для создания объекта телефона
function createPhoneObject(phone) {
  return {
    phone: phone.text,
    isRemovable: phone.isRemovable || false,
    status: !!phone.status
  };
}
// Инициализация phoneList с использованием createPhoneObject
const phoneList = ref(
  Array.isArray(props.initialPhoneList)
    ? props.initialPhoneList.map(createPhoneObject)
    : []
);
console.log(5555, phoneList.value)
// Слежение за изменением props.initialPhoneList и обновление phoneList
watch(() => props.initialPhoneList, (newVal) => {
  phoneList.value = Array.isArray(newVal) ? newVal.map(createPhoneObject) : [];
});

// Добавление нового телефона
function addPhone() {
  phoneList.value.push({ phone: '', isRemovable: true, status: false }); // используем status
}
// Удаление телефона, если он добавлен пользователем
function removePhone(index) {
  if (phoneList.value[index].isRemovable) {
    phoneList.value.splice(index, 1);
  }
}

// Сохранение списка телефонов
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
                            <button type="button" class="btn btn-primary" @click="addPhone"><i class="bi bi-plus-square"></i></button>
                        </div>
                        <div v-for="(phoneItem, index) in phoneList" :key="index" class="mb-2">
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-3 col-form-label"> </label>
                                <div class="col-sm-9 d-flex justify-content-between">
                                <input type="text" class="form-control" v-model="phoneItem.phone">
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
