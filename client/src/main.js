import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import store from './store'
import router from './router'
import axios from 'axios'
const app = createApp(App);

// Install the axios plugin
app.config.globalProperties.$axios = axios;

// Add the router instance to the app
app.use(router);
app.use(store);
app.mount('#app');
