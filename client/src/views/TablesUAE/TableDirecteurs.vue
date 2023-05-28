<template>
  <div class="overflow-x-auto border">
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
        <tr v-for="(Directeur, id) in this.Directeurs.data" :key="id">
          <td>{{ id + 1 }}</td>
          <td>{{ Directeur.PPR }}</td>
          <td>{{ Directeur.nom }}</td>
          <td>{{ Directeur.prenom }}</td>
          <td>{{ Directeur.NomEtab }}</td>
          <td>{{ Directeur.Email }}</td>
          <td>{{ Directeur.DateNaissance }}</td>

          <td>
            <router-link :to="{ path: '/EditDirecteur/' + Directeur.id }">
              <button class="add-btn px-4">
                <i class="fas fa-pen"></i>
                <span class="tooltip" data-tooltip="inspect"></span>
              </button>
            </router-link>

            <button class="add-btn px-4" @click="deleteDirecteur(Directeur.id)">
              <i class="fas fa-trash"></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
            <router-link>
              <button class="add-btn px-2">
                <i class="fas fa-eye"></i>
                <span class="tooltip" data-tooltip="inspect"></span>
              </button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-outline btn-success" @click="RedirectAdd()">Ajouter un Directeur</button>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      Directeurs: []
    }
  },

  mounted() {

    this.getDirecteurs();
    console.log('test axios')

  },
  methods: {
    async getDirecteurs() {
      try {
        await axios.get('http://127.0.0.1:8000/api/Directeur').then(result => {
          this.Directeurs = result.data
        })
        console.log(this.Directeurs.data)
      }
      catch (error) {
        console.log(error)
      }
    },

    RedirectAdd() {
      this.$router.push('/AddDirecteur')
    },

    deleteDirecteur(DirecteurId){
      axios.delete(`http://127.0.0.1:8000/api/Directeur/${DirecteurId}`)
      .then(res=>{
        console.log(res.data)
        this.getDirecteurs()
      })
    }
  }

}
</script>

<style></style>