<template>
<router-view></router-view>
</template>

<script>
import {mapGetters, mapActions, mapState} from "vuex";
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

  async created(){
    if(store.state.user.token && this.IsExpired)
    {
      await this.$store.dispatch('RefreshToken');
      console.log('success')
    }
  }

}
</script>

<style scoped>

</style>