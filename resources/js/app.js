import './bootstrap';
import '../css/app.css'; 
import $ from 'jquery';

window.$ = window.jQuery = $;

import { createApp } from 'vue'

import app from './components/app.vue'
import router from './router/index.js'
import Uploader from 'vue-media-upload';
createApp(app).component('Uploader', Uploader).use(router).mount('#app')