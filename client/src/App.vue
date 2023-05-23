<template>

  <Header/>

<RouterView></RouterView>
<Footer/>
      


  
</template>

<script >
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';



export default{
  name:'App',
  components:{
    Header,
    Footer,
},
  props:{
    title:{
      type:String,
      default:'ERR',
    }
  },


}
</script>