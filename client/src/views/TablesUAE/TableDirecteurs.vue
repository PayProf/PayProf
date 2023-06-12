<template>
  <div class="overflow-x-auto border z-10">
    <table class="table w-screen botrder">
      <!-- head -->
      <thead>
        <tr>
          <th></th>
          <th>PPR</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Etablissement</th>
          <th>Email Personnel</th>
          <th>Date Naissance</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="Directeur in this.Directeurs" :key="Directeur.id">
          <td>{{ Directeur.id + 1 }}</td>
          <td>{{ Directeur.PPR }}</td>
          <td>{{ Directeur.nom }}</td>
          <td>{{ Directeur.prenom }}</td>
          <td>{{ Directeur.NomEtab }}</td>
          <td>{{ Directeur.Email }}</td>
          <td>{{ Directeur.DateNaissance }}</td>

          <td>
            <router-link :to="{ path: '/EditDirecteur/' + Directeur.id }" v-if="this.Userrole == 2">
              <button class="add-btn px-4">
                <i class="fas fa-pen"></i>
                <span class="tooltip" data-tooltip="inspect"></span>
              </button>
            </router-link>

            <button class="add-btn px-4" @click="deleteDirecteur(Directeur.id)" v-if="this.Userrole == 2">
              <i class="fas fa-trash"></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
              <button class="add-btn px-2">
                <i class="fas fa-eye"></i>
                <span class="tooltip" data-tooltip="inspect"></span>
              </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <AddDirecteur v-if="this.Userrole == 2" />
</template>

<script>
import axios from 'axios';
import store from "../../store.js";
import AddDirecteur from '../../components/AddDirecteur.vue';

export default {
  data() {
    return {
      Directeurs:[],
      Userrole:store.state.user.role,
      openAdd:false,
    }
  },
  components:{
    AddDirecteur
  },

  mounted() {

    this.getDirecteurs();

  },
  computed:{
  },
  methods: {
    async getDirecteurs() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('http://127.0.0.1:8000/api/Directeur',config).then(result => {
          this.Directeurs = result.data.data
        })
        console.log(this.Directeurs)
      }
      catch (error) {
        console.log(error)
      }
    },

    RedirectAdd() {
      this.openAdd = !this.openAdd
    },

    deleteDirecteur(DirecteurId){
      const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
      axios.delete(`http://127.0.0.1:8000/api/Directeur/${DirecteurId}`,config)
      .then(res=>{
        console.log(res.data)
        this.getDirecteurs()
      })
    }
  }

}
</script>

<style></style>