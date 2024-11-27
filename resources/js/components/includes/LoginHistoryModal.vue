

<script setup>
import { defineProps } from 'vue';

const props = defineProps({

    data: {
         type: Array,
        default: () => [],
    },
});

</script>
<template>

   <div class="card">
            <div class="card-body">
              <div class="modal fade" id="loginhHistory" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Նախորդ մուտքեր</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ip</th>
                    <th scope="col">Օր/ժամանակ</th>
                    <th scope="col">Կարգավիճակ</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item,index) in  data" :key="item.id">

                    <th scope="row">{{ ++index }}</th>
                    <td>{{ item.ip }}</td>
                    <td>{{ item.date }}</td>
                    <td>{{ item.status == 1 ? 'Հաջող' : 'Անհաջող' }}</td>
                  </tr>
                </tbody>
              </table>


                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Փակել</button>
                      <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->

            </div>
    </div>

</template>
