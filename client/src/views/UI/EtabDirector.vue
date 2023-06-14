<template>
  <div class="hero min-h-screen bg-base-200" v-if="IsLoading">
    <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
         role="status">
      <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
    </div>
  </div>
  <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12" v-else>
    <div class="col-span-1">
      <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-40" v-drag>
        <li @click="showProfile" v-if="OpenProfile" href="#tableEns" class="bg-neutral text-white">
          <i class="fa-solid fa-user"></i>
        </li>
        <li @click="showProfile" v-else>
          <i class="fa-solid fa-user"></i>
        </li>
        
          <li @click="showEns" v-if="OpenEns" class="bg-neutral text-white Interventions">
          <i class="fa-solid fa-user-tie"></i>
        </li>
        <li @click="showEns" v-else class="Interventions">
          <i class="fa-solid fa-user-tie"></i>
        </li>
        
        <div v-if="this.userRole==1">
        <li @click="ShowAllint" v-if="OpenInt" class="bg-neutral text-white">
          <i class="fa-solid fa-chalkboard-user"></i>
        </li>
        <li @click="ShowAllint" v-else>
          <i class="fa-solid fa-chalkboard-user"></i>
        </li>
      </div>
        <li>
          <i class="fa-solid fa-arrows-up-down-left-right"></i>
        </li>
      </ul>
    </div>
    <div class="col-span-11">
      <div v-if="OpenProfile" class="card card-side bg-base-100 shadow-xl">
        <div class="card-body">
          <h1 class="text-2xl font-bold">Bonjour Monsieur Le Directeur de {{ Profile.NomEtab}}</h1>
          <p class="py-2"><strong>PPR :</strong> {{Profile.PPR}}</p>
          <p class="py-2"><strong>Nom:</strong> {{Profile.nom}}</p>
          <p class="py-2"><strong>Prenom :</strong> {{Profile.prenom}}</p>
          <p class="py-2"><strong>Email :</strong> {{Profile.Email}}</p>
          <p class="py-2"><strong>Etablissment :</strong> {{ Profile.NomEtab}}</p>
          <p class="py-2"><strong>Ville :</strong> {{ Profile.DateNaissance }}</p>
          <div class="card-actions justify-end">
            <button class="btn btn-primary">Change Password</button>
          </div>
        </div>
      </div>
      <TableEnseignant id="tableEns" v-if="OpenEns" :IdEtab="IdEtab"/>
      <ValidateIntervention v-if="OpenInt"/>

    </div>


  </div>


</template>



<script>
import store from '../../store'
import axios from 'axios';
import TableEnseignant from '../TablesEtab/TableEnseignant.vue';
import ValidateIntervention from '../TablesEtab/ValidateIntervention.vue';
import PopupForm from '../../components/AddEnseignant.vue';
import TableEnseignantUAE from '../TablesUAE/TableEnseignant.vue'
import {mapActions,mapState} from 'vuex';
export default {
  name: 'Admin',
  components: {
    TableEnseignant,
    PopupForm,
    ValidateIntervention,

  },
  data() {
    return {
      userRole:store.state.user.role,
      showPopupForm: false,
      OpenEns:false,
      OpenGraphe:false,
      OpenProfile:true,
      OpenInt:false,
      IsLoading:false,
      Profile:{
        PPR:'',
        nom:'',
        prenom:'',
        email:'',
        etablissement:'',
      },
      Etablissement:{

      },
      MonDir:[],
      IdEtab:'',

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
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/etablissements/'+store.state.user.id+'/myetablissement',config);
        this.Etablissement=response.data.data;

      }
      catch(error){
        console.log(error)
      }
    },
    async GetDirEtab(){
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/etablissements/'+this.$route.params.id+'/myetablissement',config);
        this.Etablissement=response.data.data;
        console.log(response)

      }
      catch(error){
        console.log(error)
      }
    },
    async GetDir(){
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/Directeur/'+this.$route.params.id,config);
        this.Profile=response.data.data;
        console.log(response)

      }
      catch(error){
        console.log(error)
      }
    },
    async showmyprofile(){
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/Directeur/dir/ShowMyProfil',config);
        this.Profile=response.data.data;
        this.IdEtab=this.Profile.IdEtablissement;

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
    },
    showGraphe(){
      this.OpenGraphe = !this.OpenGraphe;
    }
  },

  computed:{
    ...mapState([
      'enseignants',
      'user'
    ])

  },
  async mounted() {
    if(this.userRole==1){
      this.IsLoading=true;
      await this.showmyprofile();
      // await this.GetMyEtab();
      this.IsLoading=false;
    }
    if(this.userRole==4){
      await this.GetDir();
      await this.GetDirEtab();
    }
    
  },
};


</script>

