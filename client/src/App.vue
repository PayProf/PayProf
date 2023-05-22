<template>
  
<div class="flex flex-row"><Header title="PayProf"/></div>
<div>
  <RouterView></RouterView>
</div>

  <Footer/>
  
</template>
<!-- test -->
<script >
import {RouterView,RouterLink} from "vue-router"
import { def } from '@vue/shared';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import store from "./store.js";



export default{
  name:'App',
  components:{
    Header,
    Footer,
    // Home
    
    
},
  props:{
    title:{
      type:String,
      default:'ERR',
    }
  },


}
</script>