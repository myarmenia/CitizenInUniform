<script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
  initialEmail: {
    type: String,
    required: true,
  },

});


const emit = defineEmits()
const email = ref(props.initialEmail);

function onStatusChange(event) {
  email.value.status = event.target.checked; // Update email.status based on checkbox
}

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
                                <div class="col-sm-9 d-flex justify-content-between">
                                    <input type="email" class="form-control" v-model="email.text">

                                    <div class="form-check form-switch mx-2">
                                        <input class="form-check-input change_status" type="checkbox" role="switch" :checked="email.status"  @change="onStatusChange" >
                                    </div>

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
