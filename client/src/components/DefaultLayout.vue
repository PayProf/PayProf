<template>
<!--  <Header/>-->
<router-view></router-view>
</template>

<script>
import {mapGetters, mapActions, mapState} from "vuex";
import Header from "./Header.vue";
import store from "../store.js";

export default {
  name: "DefaultLayout",

  computed:{
    ...mapState([
        'user'
    ]),
    ...mapGetters([
        'IsExpired',
    ]),
},

  methods: {
    ...mapActions([
      'RefreshToken',
    ]),
  },

  /*Right after the creation of the view
    I verify the validity of the token if the token expired
    I refresh it*/

  async created(){
    if(store.state.user.token && this.IsExpired)
    {
      await this.$store.dispatch('RefreshToken');
    }
  }

}
</script>

<style scoped>

</style>