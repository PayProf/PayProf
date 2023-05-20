<template>
<div class="w-screen h-70vh" style="margin-bottom: 40px;">
  <!-- profile card -->
  <div class="flex items-start justify-start mt-200" style="margin-top: 200px; margin-left: 20px;">
    <div class="w-1/2">
      <!-- User Information -->
      <div class="bg-gray-200 p-4">
        <h1 class="text-2xl font-bold">Profile enseignat : Mouad Hayaoui</h1>
        <p class="py-2"><strong>PPR :</strong> 123456</p>
        <p class="py-2"><strong>Nom:</strong> Hayaoui</p>
        <p class="py-2"><strong>Prenom :</strong> Mouad</p>
        <p class="py-2"><strong>Email :</strong> johndoe@example.com</p>
        <p class="py-2"><strong>Etablissment :</strong> Ecole Nationale des sciences appliquee</p>
        

      </div>
    </div>
  </div>
  <div class="w-200 h-200 bg-gray-200">
    <BarChart/>
  </div>
</div>


<div class="overflow-x-auto" style="margin-left: 20px; margin-right: 50px;">
    <h1 style=" margin-top: 0px;">Table Intervention :</h1>
    <div class="search-bar-container">
      
    <input type="text" class="search-bar" v-model="searchText" placeholder="Search" @input="filterTable">
  </div>
  <table class="table table-zebra w-full">
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
    <!-- body -->
    <tbody>
      <tr v-for="(intervention) in Interventions" :key="intervention.Id_Intr">         
        <td><input type="checkbox" /></td>
        <td>{{  intervention.Id_Intr }}</td>
            <td>{{ intervention.Etablisment }}</td>
            <td>{{intervention.Intitule_Intervention }}</td>
            <td>{{intervention.Annee_universitaire }}</td>
            <td>{{intervention.Semester }}</td>
            <td>{{intervention.Date_Debut }}</td>
            <td>{{intervention.Date_Fin }}</td>
            <td>{{intervention.Nombre_heures }}</td>
            <td>
        <button class="delete-btn">
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
<div class="btn-group" style="display: flex; justify-content: center; margin-top: 30px;">
  <button class="btn">1</button>
  <button class="btn btn-active">2</button>
  <button class="btn">3</button>
  <button class="btn">4</button>
</div>
<PFintervention/>

  <button class="btn" @click="Reset">Reset State</button>

</template>

<script>
import {mapActions,mapState,mapMutations} from 'vuex';
import PFintervention from '../../components/PFintervention.vue';
import BarChart from '/src/components/chart.vue'
export default {
    name:'User',
    components:{
      PFintervention,
      BarChart,
    },
  methods: {
    ...mapActions([
      'getInterventions'
    ]),
    ...mapMutations([
        'ResetCurrentUser',
    ]),
    Reset(){
      this.$store.commit('ResetCurrentUser');
    }
  },
  computed:{
    ...mapState([
        'Interventions',
    ])
  },
  async created(){
    await this.$store.dispatch('getInterventions');
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
    margin-right: 20px;
    
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