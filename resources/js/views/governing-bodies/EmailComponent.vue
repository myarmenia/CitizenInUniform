<script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
  initialEmail: {
    type: String,
    required: true,
  },
//   initialPhoneList: {
//     type: Array,
//     required: true,
//   }
});

// const emit = defineEmits();
const emit = defineEmits()
const email = ref(props.initialEmail);
// const phones = ref(props.initialPhoneList);

function saveData() {
    emit('save', email.value);

}
</script>


<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-10">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Խմբագրել</h5>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">Էլ․ փոստ </label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" v-model="email">
                                    <input type="checkbox" class="form-control" v-model="checkrd">

                                    <!-- <div class="mb-3 row " v-if="errors.email">
                                        <p class="col-sm-10 text-danger fs-6" v-for="error in errors.email">{{ error }}
                                        </p>
                                    </div> -->
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary" @click="saveData">Պահպանել</button>

                                    <button @click="$emit('cancel')" class="btn btn-secondary">Չեղարկել</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
