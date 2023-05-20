import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import store from './store'
import router from './router'
import axios from 'axios'
import Setdefaults from './axios.js'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const app = createApp(App);

// Install the axios plugin
app.config.globalProperties.$axios = axios;


// Add the router instance to the app
createApp(App)
    .use(router)
    .use(store)
    .use(Toast)
    .mount('#app');

Setdefaults();
