<template>
    <table class="table table-zebra w-full">
      <!-- head -->
      <thead>
      <tr>
        <th><input type="checkbox" /></th>
        <th>PPR</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
      <!-- This import the users from store.state in the table -->
      <tr v-for="(enseignant,index) in $store.state.enseignants " :key="index">
        <th><input type="checkbox" /></th>
        <td>{{ enseignant.ppr }}</td>
        <td>{{  enseignant.nom  }}</td>
        <td>{{ enseignant.prenom }}</td>
        <td>{{enseignant.email }}</td>
        <td><button class="delete-btn" ><i class="fas fa-trash"></i></button><button class="inspect-btn"><i class="fas fa-search"></i></button><button class="add-btn" @click="showPopupForm = true"><i class="fas fa-plus"></i></button></td>


      </tr>
      </tbody>
    </table>
</template>

<script>
import {mapState,mapActions} from 'vuex'
import axios from "axios"
import axiosinstance from "../../axios.js";
export default {
  name: "Director",
  data(){
    return {
      done:false,
    }

  },
  computed:{
    ...mapState([
        'user',
    ])
  },

  methods:{
    ...mapActions([
       'getuser',
    ]),
    async getuser(){
      await this.$store.dispatch('getuser').then(console.log(this.user.nom)
      ,this.done=true)

    }
  }
}
</script>

<style scoped>
.delete-btn,
.add-btn,
.inspect-btn {
  position: relative;
  display: inline-block;
  padding: 0;
  border: none;
  background: none;
  cursor: pointer;
  margin-right: 10px;

}

.tooltip {
  position: absolute;
  background-color: gray;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  visibility: hidden;
  opacity: 0;
  transition: opacity 0.2s, visibility 0s linear 0.2s;
  pointer-events: none;
  white-space: nowrap;
}

.delete-btn:hover .tooltip,
.add-btn:hover .tooltip,
.inspect-btn:hover .tooltip {
  visibility: visible;
  opacity: 1;
  transition-delay: 0s;
}

.tooltip:before {
  content: attr(data-tooltip);
  position: absolute;
  top: -25px;
  left: 50%;
  transform: translateX(-50%);
}
.search-bar-container {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 10px;
}

.search-bar {
  width: 200px;
  margin-left: 10px;
}
</style>