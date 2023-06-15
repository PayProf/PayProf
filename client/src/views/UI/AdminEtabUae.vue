<template>
    <div class="hero min-h-screen bg-base-200" v-if="IsLoading">
      <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
           role="status">
        <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
      </div>
    </div>
    <div class="p-4 min-h-screen sm:mx-30 grid grid-cols-12" v-else>
      <div class="col-span-1">
      <ul class="menu bg-base-200 rounded-box mt-20 w-12 z-40" v-drag>
        <li @click="showProfile" v-if="OpenProfile" href="#tableEns" class="bg-neutral text-white">
          <i class="fa-solid fa-user"></i>
        </li>
        <li @click="showProfile" v-else>
          <i class="fa-solid fa-user"></i>
        </li>
        <li @click="ShowMyDir" v-if="OpenDir" class="bg-neutral text-white Interventions">
          <i class="fa-solid fa-suitcase"></i>
        </li>
        <li @click="ShowMyDir" v-else class="Interventions">
          <i class="fa-solid fa-suitcase"></i>
        </li>
        <li @click="showEns" v-if="OpenEns" class="bg-neutral text-white Interventions">
          <i class="fa-solid fa-user-tie"></i>
        </li>
        <li @click="showEns" v-else class="Interventions">
          <i class="fa-solid fa-user-tie"></i>
        </li>
       
        <li>
          <i class="fa-solid fa-arrows-up-down-left-right"></i>
        </li>
      </ul>
      </div>
      <div class="col-span-11">
    <div v-if="OpenProfile" class="card card-side bg-base-100 shadow-xl">
    <div class="card-body">
      <h1 class="text-2xl font-bold">l'Admin de {{ Etablissement.nom }}</h1>
  
            <p class="py-2"><strong>PPR :</strong> {{Profile.PPR}}</p>
            <p class="py-2"><strong>Nom:</strong> {{Profile.nom}}</p>
            <p class="py-2"><strong>Prenom :</strong> {{Profile.prenom}}</p>
            <p class="py-2"><strong>Email :</strong> {{Profile.email_perso}}</p>
            <p class="py-2"><strong>Etablissment :</strong> {{ Etablissement.nom }}</p>
            <p class="py-2"><strong>Nombre des Enseignants :</strong> {{ Etablissement.Nbrenseignants }}</p>
            <p class="py-2"><strong>Ville :</strong> {{ Etablissement.ville }}</p>
            
    </div>
  </div>
        <div v-if="OpenDir" class="card card-side bg-base-100 shadow-xl">
          <div v-if="IsDir" class="card-body">
            <h1 class="text-2xl font-bold"> Directeur de {{ Etablissement.nom }}</h1>
            <p class="py-2"><strong>PPR :</strong> {{Directeur.PPR}}</p>
            <p class="py-2"><strong>Nom:</strong> {{Directeur.nom}}</p>
            <p class="py-2"><strong>Prenom :</strong> {{Directeur.prenom}}</p>
            <p class="py-2"><strong>Email :</strong> {{Directeur.Email}}</p>
            <p class="py-2"><strong>Etablissment :</strong> {{ Directeur.NomEtab }}</p>
            <p class="py-2"><strong>Date de naissance :</strong> {{ Directeur.DateNaissance}}</p>
            </div>
          <div v-else class="card-body bg-error">
              <div class="flex justify-center items-center">
                <div class="grid grid-cols-6 w-1/3">
                  <div class="flex items-center justify-end col-span-2">
              <i class="fa-solid fa-triangle-exclamation"></i></div>
                  <div class="flex items-center justify-start gap-1 col-span-4">
                <h1> Pas de Directeur</h1></div>
                </div>
              </div>
              </div>
          </div>
        <TableEnseignant @Directeur-added="GetMyDirecteur" id="tableEns" v-if="OpenEns"/>
        </div>
      </div>
  </template>
  
    
  
  <script>
  import store from '../../store'
  import axios from 'axios';
  import TableEnseignant from '../TablesEtab/TableEnseignant.vue';
  import PopupForm from '../../components/AddEnseignant.vue';
  import {mapState} from 'vuex';

  export default {
    name: 'AdminEtabUae',
    components: {
      TableEnseignant,
      PopupForm,
      
  
    },
    data() {
      return {
        userRole:store.state.user.role,

        OpenEns:false,
        OpenGraphe:false,
        OpenProfile:true,
        OpenDir:false,
        IsDir:true,

        IsLoading:false,
        Profile:{
          PPR:'',
          nom:'',
          prenom:'',
          email:'',
          etablissement:'',
        },
        Etablissement:{},
        Directeur: {
  
        },
  
      };
    },
    methods: {
    //   ...mapActions([
    //     'getEnseignants'
    // ]),
      async GetMyEtab(){
        try {
          const token = store.state.user.token;
          const config = {
            headers: {
              Authorization: `Bearer ${token}`
  
            }
          };
          const response = await axios.get('http://127.0.0.1:8000/api/etablissements/'+store.state.user.id+'/myetablissement',config);
          this.Etablissement=response.data.data;
          console.log(response)
  
        }
        catch(error){
          console.log(error)
        }
      },
      async GetMyDirecteur(){
        try {
          const token = store.state.user.token;
          const config = {
            headers: { Authorization: `Bearer ${token}` }
          };
          const response = await axios.get('http://127.0.0.1:8000/api/Administrateur/adm/MyDir',config);
          this.Directeur=response.data.data;
  
  
        }
        catch(error){
          console.log(error)
          this.IsDir=false;
        }
      },
     
    
      async showAdmprofile(){
        try {
          const token = store.state.user.token;
          const config = {
            headers: { Authorization: `Bearer ${token}` }
          };
          const response = await axios.get('http://127.0.0.1:8000/api/admins/'+this.$route.params.id,config);
          this.Profile=response.data.data;
  
        }
        catch(error){
          console.log(error)
        }
      },
    showStats() {
        this.OpenStats = !this.OpenStats;
      },
      showEnseignatsA() {
        this.OpenEnseignants = !this.OpenEnseignants;
      },
      
      showEns(){
        this.OpenEns = !this.OpenEns;
      },
      showProfile(){
        this.OpenProfile = !this.OpenProfile;
      },
     
      showGraphe(){
        this.OpenGraphe = !this.OpenGraphe;
      },
      ShowMyDir(){
        this.OpenDir=!this.OpenDir;
      },
    },
    
    computed:{
      ...mapState([
          'enseignants',
          'user'
      ])
  
    },
    async mounted() {
      this.IsLoading=true;
      await this.GetMyEtab();
      await this.GetMyDirecteur();
      await this.showAdmprofile()
      this.IsLoading=false;
      
  },
  };
  
  
  </script>
  
  