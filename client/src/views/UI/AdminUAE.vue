<template>
    <TableAdmins v-if="showAdmin"/>
     <TableDirecteurs v-if="showDir"/>
     <TableEtablissements v-if="showEtablissement"/>
     <!-- <div v-if="showProfile" class="card card-side bg-base-100 shadow-xl">
        <div class="card-body">
          <h1 class="text-2xl font-bold">Bienvenue à Payprof {{this.Profile.nom}} {{this.Profile.prenom}} !</h1>
          <p class="py-2"><strong>PPR :</strong>{{this.Profile.PPR}}</p>
          <p class="py-2"><strong>Nom:</strong> {{this.Profile.nom}}</p>
          <p class="py-2"><strong>Prenom :</strong> {{this.Profile.prenom}}</p>
          <p class="py-2"><strong>Email :</strong> {{this.Profile.Email}}</p>
          <p class="py-2"><strong>Etablissment :</strong>{{this.Profile.NomEtab}}</p>
          <div class="card-actions justify-end">
            <button class="btn btn-primary" @click="ToggleUpdate">Change Password</button>
          </div>
        </div>
      </div> -->
    <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12">
     <div class="col-span-1">
     <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-50" v-drag>
       <li @click="toggleProfile()" v-if="showProfile" class="bg-neutral text-white">
         <i class="fa-solid fa-user"></i>
       </li>
       <li @click="toggleProfile()" v-else>
         <i class="fa-solid fa-user"></i>
       </li>
       <li @click="toggleTableAdmin()" v-if="showAdmin" class="bg-neutral text-white Interventions">
        <i class="fa-solid fa-users"></i>
       </li>
       <li @click="toggleTableAdmin()" v-else class="Interventions">
        <i class="fa-solid fa-users"></i>
       </li>
       <li @click="toggleTableDirecteur()" v-if="showDir" class="bg-neutral text-white">
        <i class="fa-solid fa-suitcase"></i>
       </li>
       <li @click="toggleTableDirecteur()" v-else>
        <i class="fa-solid fa-suitcase"></i>
       </li>
       <li @click="toggleTableEtablissement()" v-if="showEtablissement" class="bg-neutral text-white">
        <i class="fa-solid fa-school"></i>
       </li>
       <li @click="toggleTableEtablissement()" v-else>
        <i class="fa-solid fa-school"></i>
       </li>
       
       <li>
         <i class="fa-solid fa-arrows-up-down-left-right"></i>
       </li>
     </ul>
     </div>
     
     </div>
 </template>
 
 <script>
 import TableAdmins from '../TablesUAE/TableAdmins.vue'
 import TableEtablissements from '../TablesUAE/TableEtablissements.vue'
 import TableDirecteurs from '../TablesUAE/TableDirecteurs.vue'
 export default {
     name: "AdminUAE",
     data(){
        return{
            showAdmin:false,
            showDir: false,
            showProfile: false,
            showEtablissement: false
        }
     },
     components:{
         TableAdmins,
         TableEtablissements,
         TableDirecteurs
     },
     methods:{
         toggleTableAdmin(){
             this.showAdmin = !this.showAdmin
         },
         toggleTableDirecteur(){
            this.showDir = !this.showDir
         },
         toggleTableEtablissement(){
            this.showEtablissement = !this.showEtablissement
         },
         toggleProfile(){
            this.showProfile = !this.showProfile
         },
         async showmyprofile(){
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/Enseignant/ens/ShowMyProfil',config);
        this.Profile=response.data.data;

      }
      catch(error){
        console.log(error)
      }
    }
 
     }
 }
 </script>
     
 <style>
 
 </style>