<template>


<Header/>
<router-view/>
<Footer/>
      


  
</template>

<script >
import {RouterView,RouterLink} from "vue-router"
import { def } from '@vue/shared';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import Etabs from './views/UI/TableEtablissements.vue';
import EtabDirecrteurs from './views/UI/TableDirecteurs.vue';
import EtabAdmins from './views/UI/TableAdmins.vue';
import AdminUAE from './views/UI/AdminUAE.vue';
import DirecteurUAE from './views/UI/DirecteurUAE.vue';
import store from "./store.js";



export default{
  name:'App',
  components:{
    Header,
    Footer,
    Etabs,
    EtabDirecrteurs,
    AdminUAE,
    EtabAdmins,
    AdminUAE, 
    DirecteurUAE,

},
  props:{
    title:{
      type:String,
      default:'ERR',
    }
  },


}
</script>