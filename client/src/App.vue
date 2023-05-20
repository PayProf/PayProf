<template>
  
<div class="flex flex-row"><Header title="PayProf"/></div>

  <RouterView></RouterView>

  <Footer/>
  
</template>
<!-- test -->
<script >
import {RouterView,RouterLink} from "vue-router"
import { def } from '@vue/shared';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';



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
  }
}
</script>
<style scoped>

</style>
