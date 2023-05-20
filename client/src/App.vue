<template>
  <Header />
  

  
</template>
<!-- test -->
<script >
import {RouterView,RouterLink} from "vue-router"
import { def } from '@vue/shared';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import AdminUAE from './views/UI/AdminUAE.vue'
import Admin from "./views/UI/Admin.vue";



export default{
  name:'App',
  components:{ 
    Header,
    Footer,
    Admin,
    AdminUAE,
},
  props:{
    title:{
      type:String,
      default:'ERR',
    }
  }
}
</script>
<style scoped>

</style>
