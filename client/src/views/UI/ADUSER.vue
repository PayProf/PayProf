<template>
  <div class="hero min-h-screen bg-base-200" v-if="Loading">
    <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
         role="status">
      <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
    </div>
  </div>
  <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12" v-else>
    <div class="col-span-1">
      <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-30" v-drag>
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
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div v-if="OpenProfile" class="card card-side bg-base-100 shadow-xl col-span-1">
        <div class="card-body">
          <h1 class="text-2xl font-bold">L'Enseignant {{ this.Enseignant.nom }} {{this.Enseignant.prenom}}</h1>
          <p class="py-2 grid grid-cols-2 gap-4"><span><strong>PPR:</strong> {{ this.Enseignant.PPR }}</span><span><strong>Grade :</strong> {{this.Enseignant.Grade}}</span></p>
          <p class="py-2 grid grid-cols-2 gap-4"><span><strong>Nom:</strong> {{ this.Enseignant.nom }}</span><span><strong>Prenom :</strong> {{this.Enseignant.prenom}}</span></p>
          <p class="py-2"><strong>Email :</strong> {{this.Enseignant.Email}}</p>
          <p class="py-2"><strong>Etablissement :</strong> {{this.Enseignant.NomEtab}}</p>
          <p class="py-2"><strong>Date Naissance :</strong> {{this.Enseignant.DateNaissance}}</p>
        </div>
      </div>
        <div v-if="OpenGraphe" class="w-200 h-200 bg-base-100 flex items-center justify-center mt-5 col-span-1 ">
          <BarChart class="w-full"/>
        </div>

      </div>

      <div v-if="OpenInterventions" id="interventiontable" class="overflow-x-auto mt-5" style="margin-left: 20px; margin-right: 50px;">
        <h1 class="text-black font-bold text-xl">Table Intervention :</h1>
        <table class="table table-zebra w-full">
          <!-- head -->
          <thead>
          <tr>
            <th>Intitule</th>
            <th>Année</th>
            <th>Semestre</th>
            <th>Date Debut</th>
            <th>Date Fin</th>
            <th>Nombre Heures</th>
            <th>Visa UAE</th>
            <th>Visa Etab</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="intervention in Interventions" :key="intervention.id">
            <td>{{ intervention.IntituleIntervention }}</td>
            <td>{{ intervention.AnneeUniv }}</td>
            <td>{{ intervention.Semestre }}</td>
            <td>{{ intervention.DateDebut }}</td>
            <td>{{ intervention.DateFin }}</td>
            <td>{{ intervention.Nbrheures }}</td>
            <td>
              <div class="flex justify-center">
                <i class="fa-solid fa-x text-red-500" v-if="!intervention.VisaUae"></i>
                <i class="fa-solid fa-check text-green-500" v-else></i>
              </div>
            </td>
            <td>
              <div class="flex justify-center">
                <i class="fa-solid fa-x text-red-500" v-if="!intervention.VisaEtab"></i>
                <i class="fa-solid fa-check text-green-500" v-else></i>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
        <div class="flex justify-center">
        <v-pagination
            v-model="page"
            :pages="pagecount"
            :range-size="1"
            active-color="#1d774d"
            @update:modelValue="getInterventions(this.$route.params.id)"
        />
        </div>
      </div>


    </div>
  </div>
</template>

<script>
import axios from 'axios';
import store from '../../store';
import { mapActions, mapState } from 'vuex';
import AddIntervention from '../../components/AddIntervention.vue';
import BarChart from '../../components/admincharts.vue';
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";

export default {
  name: 'ADUser',
  data(){
    return{
      OpenInterventions:true,
      OpenProfile:true,
      OpenGraphe:true,
      OpenDelete:false,
      Enseignants:null,
      page:1,
      pagecount:null,
      Interventions:[],
      Enseignant: {
      },
      Loading:false,
    }
  },
  components: {
    // PFintervention,
    BarChart,
    AddIntervention,
    VPagination,
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
    async getInterventions(id) {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };

        const res= await axios.get('http://127.0.0.1:8000/api/Intervention/'+id+'/EnseignantInterventions?page='+this.page,config)
        this.Interventions=res.data.data
        this.pagecount=res.data.meta.last_page
        console.log( this.Interventions)
      }
      catch (error) {
        console.log(error)
      }
    },
    async getEnseignantProfile(id){
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };

        const res= await axios.get('http://127.0.0.1:8000/api/Enseignant/'+id,config)
        this.Enseignant=res.data.data;
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
  // async created() {
  //   await this.$store.dispatch('getInterventions');
  // }
  async mounted() {
    this.Loading=true;
    const id = this.$route.params.id;
    localStorage.setItem('SELECTEDID',id);
    await this.getEnseignantProfile(id)
    await this.getInterventions(id);
    this.Loading=false;
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