<template>
   <div class="overflow-x-auto border">
  <table class="table w-screen botrder">
    <!-- head -->
    <thead>
      <tr >
        <th></th>
        <th>PPR</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Etablissement</th>
        <th>Email Personnel</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(Directeur, id) in this.Directeurs" :key="id">
          <td></td>
          <td>{{ Directeur.PPR }}</td>
          <td>{{ Directeur.Nom }}</td>
          <td>{{ Directeur.Prenom }}</td>
          <td>{{ Directeur.Telephone }}</td>
          <td>{{ Directeur.Etablissement }}</td>
          <td>{{ Directeur.Email }}</td>
          <td>
            <button class="add-btn px-2" @click="showPopupForm = true">
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
          </td>
        </tr> 
    </tbody>
  </table>
</div>
<PopupForm/>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import PopupForm from '../../components/PopupForm.vue';
import BarChart from '/src/components/chart.vue'
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
        axios.get('http://127.0.0.1/api/Directeurs').then(result => {
          this.Directeurs = result.data
        })
        console.log(response.data)
      }
      catch (error) {
        console.log(error)
      }
    },
    RedirectAdd() {
      this.$router.push('/AddDirecteur')
    }
  }

}
</script>

<style>

</style>