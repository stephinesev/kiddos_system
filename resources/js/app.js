import './bootstrap';
import '../css/app.css'; 
import $ from 'jquery';

window.$ = window.jQuery = $;

import { createApp } from 'vue'

import app from './components/app.vue'
import router from './router/index.js'
createApp(app).use(router).mount('#app')