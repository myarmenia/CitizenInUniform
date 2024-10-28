import './bootstrap';

// import 'bootstrap/dist/css/bootstrap.min.css';
import { createApp } from 'vue'
import app from './components/App.vue'

import Swal from "sweetalert2"
window.Swal = Swal
const toast = Swal.mixin({
toast: true,
position: 'top-end',
showConfirmButton: false,
timer: 3000,
timerProgressBar: true,
})
window.toast = toast

import app from './components/App.vue'
import router from './router'

createApp(app).use(router).mount("#app")
