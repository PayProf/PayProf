<template>
  <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12">
    <div class="col-span-1">
    <ul class="menu bg-base-200 rounded-box mt-6 w-12" v-drag:y>
      <li @click="showProfile" v-if="OpenProfile" class="bg-gray-500">
        <i class="fa-solid fa-user"></i>
        <a class="tooltip" data-tip="Profile">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
        </a>
      </li>
      <li @click="showProfile" v-else>
        <i class="fa-solid fa-user"></i>
        <a class="tooltip" data-tip="Profile">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
        </a>
      </li>
      <li @click="showInterventions" v-if="OpenInterventions" class="bg-gray-500">
        <i class="fa-solid fa-chalkboard-user"></i>
        <a class="tooltip" data-tip="Interventions">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </a>
      </li>
      <li @click="showInterventions" v-else>
        <i class="fa-solid fa-chalkboard-user"></i>
        <a class="tooltip" data-tip="Interventions">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </a>
      </li>
      <li @click="showGraphe" v-if="OpenGraphe" class="bg-gray-500">
        <i class="fa-sharp fa-solid fa-signal"></i>
        <span class="tooltip" data-tip="Stats">
<!--          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>-->
        </span>
      </li>
      <li @click="showGraphe" v-else>
        <i class="fa-sharp fa-solid fa-signal"></i>
        <span class="tooltip" data-tip="Stats">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
        </span>
      </li>
    </ul>
    </div>
    <!-- delete card accepting -->
    <div class="col-span-11">
    <div>
    <div v-if="OpenDelete"  id="profilecard" class="popup-overlay">
      <div class="popup-container">
        <div class="card w-96 bg-neutral text-neutral-content">
          <div class="card-body items-center text-center">
            <h2 class="card-title">WARNING !</h2>
            <p>Are you sure you want to delete the intervention?</p>
            <div class="card-actions justify-end">
              <button @click="supIntervention()" class="btn btn-primary">Accept</button>
              <button @click="OpenDelete = false" class="btn btn-ghost">Deny</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-if="OpenProfile" class="card card-side bg-base-100 shadow-xl">
  <div class="card-body">
    <h1 class="text-2xl font-bold">Profile enseignat : Mouad Hayaoui</h1>
          <p class="py-2"><strong>PPR :</strong> 123456</p>
          <p class="py-2"><strong>Nom:</strong> Hayaoui</p>
          <p class="py-2"><strong>Prenom :</strong> Mouad</p>
          <p class="py-2"><strong>Email :</strong> johndoe@example.com</p>
          <p class="py-2"><strong>Etablissment :</strong> Ecole Nationale des sciences appliquee</p><h2 class="card-title">New movie is released!</h2>
    <p>Click the button to watch on Jetflix app.</p>
    <div class="card-actions justify-end">
      <button class="btn btn-primary">Change Password</button>
    </div>
  </div>
</div>
  <div v-if="OpenInterventions" id="interventiontable" class="overflow-x-auto mt-5" style="margin-left: 20px; margin-right: 50px;">
    <h1 style=" margin-top: 0;">Table Intervention :</h1>
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
            <button class="inspect-btn">
              <i class="fa-solid fa-eye"></i>
              <span class="tooltip" data-tooltip="Inspect">Inspect intervention </span>
            </button>
            <button @click="showDeleteW" class="delete-btn" v-if="IsAdmin">
              <i class="fas fa-trash"></i>
              <span class="tooltip" data-tooltip="Delete">Supprimer intervention </span>
            </button>
            <button class="add-btn" v-if="IsAdmin">
              <i class="fas fa-edit"></i>
              <span class="tooltip" data-tooltip="Edit">Edit intervention </span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <AddIntervention/>
    <div class="btn-group" style="display: flex; justify-content: center; margin-top: 30px;">
    <button class="btn">1</button>
    <button class="btn btn-active">2</button>
    <button class="btn">3</button>
    <button class="btn">4</button>
  </div>

  </div>
  <div v-if="OpenGraphe" class="w-200 h-200 bg-gray-200 mt-5 ">
    <div class="flex justify-end">
    </div>
      <BarChart />
    </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import AddIntervention from '../../components/AddIntervention.vue';
import BarChart from '../../components/chart.vue'
import store from "../../store.js";
import axios from "axios";

export default {
  name: 'User',
  data(){
    return{
      OpenInterventions:false,
      OpenProfile:true,
      OpenGraphe:false,
      OpenDelete:false,
      IsAdmin:store.state.user.role===2,
    }
  },
  components: {
    // PFintervention,
    BarChart,
    AddIntervention,
  },
  methods: {
    showInterventions(){
      this.OpenInterventions=!this.OpenInterventions;
    },
    showProfile(){
      this.OpenProfile=!this.OpenProfile;
    },
    showGraphe(){
      this.OpenGraphe=!this.OpenGraphe;
    },
    supIntervention(id){
      this.OpenDelete =!this.OpenDelete;
    },
    showDeleteW(){
      this.OpenDelete =!this.OpenDelete;
    },
    async getInterventions() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/Enseignant/'+store.state.user.id+'/MyIntervention')
        //     .then(result=>{
        //   this.Interventions = result.data
        // })
        console.log(store.state.user.id)
        console.log(response.data)
      }
      catch (error) {
        console.log(error)
      }
    }
  },
  computed: {
    ...mapState([
      'Interventions',
    ]),
    
  },
  mounted() {

    this.getInterventions();
    console.log('test axios')

  },
}
</script>


<style scoped>
.delete-btn,
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

.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.popup-container {
  max-width: 500px;
}
</style>