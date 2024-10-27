
<script setup>
import { reactive } from "vue"

const form = reactive({
    title:"",
})

const handleSave = () =>{
    axios.post('/api/create-faq-category',form)

}


</script>
<template>
    <main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Elements</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Elements</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">General Form Elements</h5>

              <!-- General Form Elements -->
              <!-- <form> -->
               <div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Text</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="form.title">
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Submit Button</label>
                  <div class="col-sm-10">
                    <button class="btn btn-primary" @click="handleSave">Submit Form</button>
                  </div>
                </div>

              <!-- </form> -->
               </div>
              <!-- End General Form Elements -->

            </div>
          </div>

        </div>


      </div>
    </section>

  </main>
</template>
