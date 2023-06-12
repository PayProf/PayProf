<template>
    <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12">
      <div class="col-span-1">
      <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-50" v-drag>
        <li @click="showProfile" v-if="OpenProfile" href="#tableEns" class="bg-neutral text-white">
          <i class="fa-solid fa-user"></i>
        </li>
        <li @click="showProfile" v-else>
          <i class="fa-solid fa-user"></i>
        </li>
        <li @click="showEns" v-if="OpenInterventions" class="bg-neutral text-white Interventions">
          <i class="fa-solid fa-chalkboard-user"></i>
        </li>
        <li @click="showEns" v-else class="Interventions">
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
      <!-- <div>
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
    </div> -->
    <div v-if="OpenProfile" class="card card-side bg-base-100 shadow-xl">
    <div class="card-body">
      <h1 class="text-2xl font-bold">Profile enseignat : Mouad Hayaoui</h1>
            <p class="py-2"><strong>PPR :</strong> </p>
            <p class="py-2"><strong>Nom:</strong> </p>
            <p class="py-2"><strong>Prenom :</strong></p>
            <p class="py-2"><strong>Email :</strong></p>
            <p class="py-2"><strong>Etablissment :</strong> Ecole Nationale des sciences appliquee</p>
      <div class="card-actions justify-end">
        <button class="btn btn-primary">Change Password</button>
      </div>
    </div>
  </div>
    
      </div>
    <!-- </> -->
  
  
    </div>
    <TableEnseignant id="tableEns" v-if="OpenEns"/>
  
  </template>


<script>
import TableEnseignant from '../TablesEtab/TableEnseignant.vue';
import store from '../../store';
import axios from 'axios';
export default {
  name: "Director",
  data() {
    return {
      done: false,
      OpenEns:false,
      OpenProfile:true,
      OpenInt:false,
      OpenInterventions: false,
      OpenGraphe: false,
    }
  },
  components:{
    TableEnseignant,
  },
  methods:{
    showEnseignatsA() {
      this.OpenEnseignants = !this.OpenEnseignants;
    },
    showInterventionsA() {
      this.OpenInterventions = !this.OpenInterventions;
    },
    showEns(){
      this.OpenEns = !this.OpenEns;
    },
    showProfile(){
      this.OpenProfile = !this.OpenProfile;
    },
    ShowAllint(){
      this.OpenInt = !this.OpenInt;
    }
  }
}


</script>



