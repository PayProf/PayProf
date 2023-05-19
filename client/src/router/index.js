import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue'
import Admin from '../views/UI/Admin.vue'
import User from '../views/UI/User.vue'
import Director from "../views/UI/Director.vue";

const routes = [
  { 
    path: '/',
    name:'Home',
   component: Home 
  },
  {
    path:'/UI/Admin',
    name:'Admin',
    component:Admin
  },
  {
    path:'/UI/User',
    name:'User',
    component:User
  },
  {
    path:'/UI/Director',
    name:'Director',
    component:Director,
  }

  // Add more routes as needed
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
