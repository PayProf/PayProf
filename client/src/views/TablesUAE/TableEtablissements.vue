<template>
  <!-- TABLE ETABLISSEMENT -->
  <div class="overflow-x-auto border">
    <table class="table w-screen botrder">
      <!-- head -->
      <thead>
        <tr>
          <th></th>
          <th>Code</th>
          <th>Nom</th>
          <th>Télephone</th>
          <th>Fax</th>
          <th>Nombre enseignants</th>
          <!-- Consulter la table des enseignants de cet etablissement -->
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(Etablissement, id) in this.Etablissements" :key="id">
          <td></td>
          <td>{{ Etablissement.Code }}</td>
          <td>{{ Etablissement.Nom }}</td>
          <td>{{ Etablissement.Telephone }}</td>
          <td>{{ Etablissement.Fax }}</td>
          <td>{{ Etablissement.Nombre_enseignants }}</td>
          <td>
            <button class="add-btn px-2" @click="showPopupForm = true">
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-outline btn-secondary  ml-5 mt-2 text-black" >Button</button>
  </div>
</template>

<script>
import axios from 'axios'
import { mapActions, mapState } from 'vuex';
import { onMounted } from 'vue'

export default {

  name: 'Etablissements',
  data() {
    return {
      Etablissements: []
    }
  },

  mounted() {

    this.getEtablissements();
    console.log('test axios')

  },
  methods: {
    async getEtablissements() {
      try {
        axios.get('http://127.0.0.1/api/Etablissement').then(result=>{
          this.Etablissements = result.data
        })
        console.log(response.data)
      }
      catch (error) {
        console.log(error)
      }
    }
  },
 
}
</script>

<style></style>