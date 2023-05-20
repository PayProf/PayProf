<template>
      <Header/>
      <EtabAdmins/>
      <Footer/>

  
</template>
<!-- test -->
<script >
import {RouterView,RouterLink} from "vue-router"
import { def } from '@vue/shared';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import Etabs from './views/UI/Etabs.vue';
import EtabDirecrteurs from './views/UI/EtabDirecteurs.vue';
import EtabAdmins from './views/UI/EtabAdmins.vue';
import AdminUAE from './views/UI/AdminUAE.vue';





export default{
  name:'App',
  components:{
    Header,
    Footer,
    Etabs,
    EtabDirecrteurs,
    AdminUAE,
    EtabAdmins,
    AdminUAE
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
