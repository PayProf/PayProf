<template>
    <!-- <div class="w-screen h-70vh" style="margin-bottom: 40px;">
      <div class="flex items-start justify-start mt-200" style="margin-top: 200px; margin-left: 20px;">
        <div class="w-1/2">
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
        <BarChart />
      </div>
    </div> -->
  
    <div class="p-4 mt-20 sm:mx-30">
          <div class="p-4 border-2 border-gray-200  rounded-lg ">
              <div class="flex items-center justify-center h-60 mb-6 mt-10 rounded bg-gray-50 ">
                  <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                      <figure><img src="" alt=""  /></figure>
                      <div class="card-body">
                          <h2 class="card-title">Table des Interventions</h2>
                          <p>Afficher les informations detailees des intervention dans cette annee</p>
                          <div class="card-actions justify-end">
                              
                              <button class="btn btn-primary" @click="showInterventions" href="#interventiontable">Consulter</button>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="grid grid-cols-2 gap-6 mb-4 pt-6">
                  <div class="flex items-center justify-center rounded bg-gray-50 h-40 ">
                      <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                          <figure><img src="" alt=""  /></figure>
                          <div class="card-body">
                              <h2 class="card-title">Graphes des nombres d'heures travaille cette annee</h2>
                              <p>...</p>
                              <div class="card-actions justify-end">
                                  <button class="btn btn-primary" @click="showGraphe">Consulter</button>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="flex items-center justify-center rounded bg-gray-50 h-40 ">
                      <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                          <figure><img src="" alt=""  /></figure>
                          <div class="card-body">
                              <h2 class="card-title">Afficher tous les informations de l'enseignant</h2>
                              <p>....</p>
                              <div class="card-actions justify-end">
                                  <button class="btn btn-primary mb-3" @click="showProfile" href="#profilecard">Consulter</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- delete card accepting -->
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
            <p class="py-2"><strong>Nom:</strong> {{ Enseignants.nom}}</p>
            <p class="py-2"><strong>Prenom :</strong> Mouad</p>
            <p class="py-2"><strong>Email :</strong> johndoe@example.com</p>
            <p class="py-2"><strong>Etablissment :</strong> Ecole Nationale des sciences appliquee</p><h2 class="card-title">New movie is released!</h2>
      <p>Click the button to watch on Jetflix app.</p>
      <div class="card-actions justify-end">
        <button class="btn btn-primary">Change Password</button>
      </div>
    </div>
  </div>
    <div v-if="OpenInterventions" id="interventiontable" class="overflow-x-auto" style="margin-left: 20px; margin-right: 50px;">
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
      <AddIntervention/>
      <div class="btn-group" style="display: flex; justify-content: center; margin-top: 30px;">
      <button class="btn">1</button>
      <button class="btn btn-active">2</button>
      <button class="btn">3</button>
      <button class="btn">4</button>
    </div>
  
    </div>
    <div v-if="OpenGraphe" class="w-200 h-200 bg-gray-200">
        <BarChart />
      </div>
   
    
    <!--  -->
  </template>
  
  <script>
  import axios from 'axios';
  import { mapActions, mapState } from 'vuex';
  import AddIntervention from '../../components/AddIntervention.vue';
  import BarChart from '../../components/chart.vue'
  
  export default {
    name: 'ADUser',
    data(){
      return{
        OpenInterventions:false,
        OpenProfile:false,
        OpenGraphe:false,
        OpenDelete:false,
        Enseignants:null,
      }
    },
    components: {
      // PFintervention,
      BarChart,
      AddIntervention,
    },
    mounted() {
    const id = this.$route.query.id;
    this.getEnseignants(id);
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
      async getEnseignants(id) {
      try {
        await axios.get('http://127.0.0.1:8000/api/Enseignant/'+id).then(result=>{
          this.Enseignants = result.data

        })
        console.log(this.Enseignants.data)

      }
      catch (error) {
        console.log(error)
      }
    },
    deleteEnseignant(EnseignantId){
      axios.delete(`http://127.0.0.1:8000/api/admins/${AdminId}`)
      .then(res=>{
        console.log(res.data)
        this.getAdmins()
      })
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