<template>
<h1>Etablissements</h1>
  <button class="btn" @click="test">Logout</button>
</template>

<script>
import {mapActions} from "vuex";

export default {
  name: "Etabs",

  computed:{
  },

  methods:{
    ...mapActions([
       'RefreshToken'
    ]),
    async test(){
      this.$store.dispatch('RefreshToken');
    }
  },

}
</script>

<style scoped>

</style>