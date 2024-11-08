<script setup>
import { ref, watch, toRef } from 'vue';

const props = defineProps(['initialPhoneList']);
const emit = defineEmits(['save', 'cancel']);

const phoneList = ref(
  Array.isArray(props.initialPhoneList)
    ? props.initialPhoneList.map(phone => ({
        phone: phone.number,      // предполагается, что данные содержат `number`
        isRemovable: phone.isRemovable || false,
        isChecked: phone.isChecked || false // добавляем `isChecked`
      }))
    : []
);

watch(() => props.initialPhoneList, (newVal) => {
  phoneList.value = Array.isArray(newVal)
    ? newVal.map(phone => ({
        phone: phone.number,
        isRemovable: phone.isRemovable || false,
        isChecked: phone.isChecked || false
      }))
    : [];
});

// Добавление нового телефона с флагом isRemovable: true
function addPhone() {
    phoneList.value.push({ phone: '', isRemovable: true });
}

// Удаление телефона только если он добавлен пользователем
function removePhone(index) {
    if (phoneList.value[index].isRemovable) {
        phoneList.value.splice(index, 1);
    }
}

// Сохранение списка телефонов
function save() {
  const phonesToSave = phoneList.value.map(item => ({
    phone: item.phone,
    isChecked: item.isChecked
  })); // Сохраняем номера телефонов и состояния чекбоксов
  emit('save', phonesToSave);
}
</script>
<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-10">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Խմբագրել</h5>

                            <!-- <div class="row mb-3">
                                <label for="phone" class="col-sm-3 col-form-label">Էլ․ փոստ </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  id="phone"
                                        placeholder="Վերնագիր" value="form.phone">
                                    <div class="mb-3 row " v-if="errors.phone">
                                        <p class="col-sm-10 text-danger fs-6" v-for="error in errors.phone">{{ error }}
                                        </p>
                                    </div>
                                </div>
                            </div> -->

                            <div v-for="(phoneItem, index) in phoneList" :key="index" class="mb-2">
                                <div class="row mb-3">
                                    <label for="phone" class="col-sm-3 col-form-label"> </label>
                                    <div class="col-sm-9 d-flex justify-content-between">
                                        <input type="text" class="form-control"  v-model="phoneItem.phone">
<input
            type="checkbox"
            v-model="phoneItem.isChecked"
            class="form-check-input ml-2"
          />
                                        <span class="deleteFile" @click="removePhone(index)" v-if="phoneItem && phoneItem.isRemovable"><i class="bx bx-trash me-1 ml-2"></i></span>
                                    </div>
                                </div>

                            </div>
                            <button @click="addPhone" class="btn btn-primary btn-sm mt-2">Добавить номер</button>

                            <!-- <div class="mt-3">
                                <button @click="save" class="btn btn-success">Сохранить</button>

                            </div> -->

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
