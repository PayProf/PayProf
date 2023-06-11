<template>
   <div id="interventiontable" class="overflow-x-auto" style="margin-left: 20px; margin-right: 50px;">
    <h1 style=" margin-top: 0;">Table Intervention :</h1>
    <div class="search-bar-container">

      <input type="text" class="search-bar" v-model="searchText" placeholder="Search" @input="filterTable">
    </div>
   <div class="overflow-x-auto ml-20 ">
    <table class="table table-zebra w-full  ">
            <!-- head -->
            <thead>
              <tr>
               
                <th><input type="checkbox" /></th>
          <th>Id_Intr</th>
          <th>Etablisment</th>
          <th>Intitule_Intervention</th>
          <th>Annee universitaire</th>
          <th>Semester</th>
          <th>Date Debut</th>
          <th>Date Fin</th>
          <th>Nombre heures</th>
          <th>Action</th>
              </tr>
            </thead>
            <tbody>
        <tr v-for="(intervention) in Interventions" :key="intervention.Id_Intr">
          <td><input type="checkbox" /></td>
          <td>{{ intervention.Id_Intr }}</td>
          <td>{{ intervention.Etablisment }}</td>
          <td>{{ intervention.Intitule_Intervention }}</td>
          <td>{{ intervention.Annee_universitaire }}</td>
          <td>{{ intervention.Semester }}</td>
          <td>{{ intervention.Date_Debut }}</td>
          <td>{{ intervention.Date_Fin }}</td>
          <td>{{ intervention.Nombre_heures }}</td>
          <td>
            <!-- supIntervention(intervention.Id_Intr) -->
            <button @click="showDeleteW" class="delete-btn">
              <i class="fas fa-trash"></i>
              <span class="tooltip" data-tooltip="Delete">Supprimer intervention </span>
            </button>
            <button class="inspect-btn">
              <i class="fas fa-edit"></i>
              <span class="tooltip" data-tooltip="Inspect">modify intervention </span>
            </button>
            <button class="btn btn-danger btn-sm">
              <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
          </td>
        </tr>
      </tbody>
          </table>
        </div>
        <AddIntervention/>

        <div class="btn-group" style="display: flex; justify-content: center; margin-top: 30px;">
    <button class="btn">1</button>
    <button class="btn btn-active">2</button>
    <button class="btn">3</button>
    <button class="btn">4</button>
  </div>
</div>
</template>

<script>
import store from "../../store.js";
import AddIntervention from '../../components/AddIntervention.vue';

export default {
  name: 'Interventions',
  components:{
    AddIntervention,
  },
  data() {
    return {
      Interventions: []
    }
  },

  mounted() {

    this.getInterventions();
    console.log('test axios')

  },
  methods: {
    async getInterventions() {
      try {
        await axios.get('http://127.0.0.1:8000/api/Enseignant/'+store.state.user.id+'/MyIntervention').then(result=>{
          this.Interventions = result.data
        })
      }
      catch (error) {
        console.log(error)
      }
    }
  },
}
</script>

<style>

</style>