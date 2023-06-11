<template>
  <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12">
    <div class="col-span-1">
    <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-50" v-drag>
      <li @click="showProfile" v-if="OpenProfile" class="bg-neutral text-white">
        <i class="fa-solid fa-user"></i>
      </li>
      <li @click="showProfile" v-else>
        <i class="fa-solid fa-user"></i>
      </li>
      <li @click="showInterventions" v-if="OpenInterventions" class="bg-neutral text-white Interventions">
        <i class="fa-solid fa-chalkboard-user"></i>
      </li>
      <li @click="showInterventions" v-else class="Interventions">
        <i class="fa-solid fa-chalkboard-user"></i>
      </li>
      <li @click="showGraphe" v-if="OpenGraphe" class="bg-neutral text-white">
        <i class="fa-sharp fa-solid fa-signal"></i>
      </li>
      <li @click="showGraphe" v-else>
        <i class="fa-sharp fa-solid fa-signal"></i>
      </li>
      <li>
        <i class="fa-solid fa-arrows-up-down-left-right"></i>
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
      <div v-if="OpenProfile && IsUpdate" class="card card-side bg-base-100 shadow-xl">
        <div class="card-body">
          <h1 class="text-2xl font-bold">Bienvenue à Payprof {{this.Profile.nom}} {{this.Profile.prenom}} !</h1>
          <p class="py-2"><strong>PPR :</strong> {{this.Profile.PPR}}</p>
          <p class="py-2"><strong>Nom:</strong> {{this.Profile.nom}}</p>
          <p class="py-2"><strong>Prenom :</strong> {{this.Profile.prenom}}</p>
          <p class="py-2"><strong>Email :</strong> {{this.Profile.Email}}</p>
          <p class="py-2"><strong>Etablissment :</strong>{{this.Profile.NomEtab}} test</p>
          <div class="card-actions justify-end">
            <button class="btn btn-primary" @click="ToggleUpdate">Update Profile</button>
          </div>
        </div>
      </div>
        <div v-if="OpenProfile && !IsUpdate" class="card card-side bg-base-100 shadow-xl">
        <div class="card-body">
          <h1 class="text-2xl font-bold">Bienvenue à Payprof {{this.Profile.nom}} {{this.Profile.prenom}} !</h1>
                <p class="py-2"><strong>PPR :</strong> {{this.Profile.PPR}}</p>
                <p class="py-2"><strong>Nom:</strong> {{this.Profile.nom}}</p>
                <p class="py-2"><strong>Prenom :</strong> {{this.Profile.prenom}}</p>
                <p class="py-2"><strong>Email :</strong> {{this.Profile.Email}}</p>
                <p class="py-2"><strong>Etablissment :</strong>{{this.Profile.NomEtab}}</p>
          <div class="card-actions justify-end">
            <button class="btn btn-primary" @click="ToggleUpdate">Update Profile</button>
          </div>
  </div>
        </div>
</div>
  <div v-if="OpenInterventions" id="interventiontable" class="overflow-x-auto mt-5" style="margin-left: 20px; margin-right: 50px;">
    <h1 class="text-black font-bold text-xl">Table Intervention :</h1>
    <table class="table table-zebra w-full">
      <!-- head -->
      <thead>
        <tr>
          <th>Intitule          </th>
          <th>Année</th>
          <th>Semestre</th>
          <th>Date Debut</th>
          <th>Date Fin</th>
          <th>Nombre Heures</th>
          <th v-if="IsAdmin">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="intervention in Interventions" :key="intervention.id">
          <td>{{ intervention.IntituleIntervention }}</td>
          <td>{{ intervention.AnneeUniv }}</td>
          <td>{{ intervention.Semestre }}</td>
          <td>{{ intervention.DateDebut }}</td>
          <td>{{ intervention.DateFin }}</td>
          <td>{{ intervention.NbrHeures }}</td>
          <td v-if="IsAdmin">
            <button @click="showDeleteW" class="delete-btn" >
              <i class="fas fa-trash"></i>
              <span class="tooltip" data-tooltip="Delete">Supprimer intervention </span>
            </button>
            <button class="add-btn">
              <i class="fas fa-edit"></i>
              <span class="tooltip" data-tooltip="Edit">Edit intervention </span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <AddIntervention v-if="IsAdmin"/>
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
</template>

<script>
import { mapActions, mapState } from 'vuex';
import AddIntervention from '../../components/AddIntervention.vue';
import BarChart from '../../components/chart.vue'
import store from "../../store.js";
import axios from "axios";
import TableInterventionsUserVue from '../TablesEtab/TableInterventionsUser.vue';


export default {
  name: 'User',
  data(){
    return{
      OpenInterventions:false,
      OpenProfile:true,
      OpenGraphe:false,
      OpenDelete:false,
      IsAdmin:store.state.user.role===2,
      Interventions:[],
      Profile: {
        nom:'',
        prenom:'',
        PPR:'',
        Email:'',
        NomEtab:'',
      },
      IsUpdate:false,
    }
  },
  components: {
    // PFintervention,
    BarChart,
    AddIntervention,
    TableInterventionsUserVue,
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
    ToggleUpdate(){
      this.IsUpdate=!this.IsUpdate;
    },
    async getInterventions() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/Enseignant/ens/MyIntervention',config)
        this.Interventions=response.data.data[0].interventions;
      }
      catch (error) {
        console.log(error)
      }
    },
    async showmyprofile(){
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        console.log(token)
        const response = await axios.get('http://127.0.0.1:8000/api/Enseignant/ens/ShowMyProfil',config);
        console.log(response)
        this.Profile=response.data.data;

      }
      catch(error){
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
    this.showmyprofile();
    this.getInterventions();

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
.Graphe:hover .tooltip,
.Profile:hover .tooltip,
.Interventions:hover .tooltip,
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