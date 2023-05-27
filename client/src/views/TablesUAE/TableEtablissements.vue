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
        <tr v-for="(Etablissement, id) in this.Etablissements.data" :key="id">
          <td>{{ Etablissement.id }}</td>
          <td>{{ Etablissement.code }}</td>
          <td>{{ Etablissement.Nom }}</td>
          <td>{{ Etablissement.Telephone }}</td>
          <td>{{ Etablissement.ville }}</td>
          <td>{{ Etablissement.Nombre_des_enseignants }}</td>
          <td>
            <button class="add-btn px-2">
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
import axios from 'axios';
export default {

  name: 'TableEtablissement',
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
        await axios.get('http://127.0.0.1:8000/api/etablissements').then(result=>{
          console.log('test axios')
          this.Etablissements = result.data
        })
        console.log(this.Etablissements)
      }
      catch (error) {
        console.log(error)
      }
    }
  },
 
}
</script>

<style></style>