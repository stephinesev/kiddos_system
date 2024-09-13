import './bootstrap';
import { createApp } from 'vue'

import app from './components/app.vue'
import router from './router/index.js'
import Uploader from 'vue-media-upload';


// import { TailwindPagination } from 'laravel-vue-pagination';
createApp(app).component('Uploader', Uploader).use(router).mount("#app")
