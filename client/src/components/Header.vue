<template>


  <div class="navbar bg-base-100 fixed top-0 w-full drop-shadow-md mb-10 z-50" id="header">
    <div class="navbar-start">

         

        

      </div>
    <div class="navbar-center">
      <a class="btn btn-ghost normal-case text-xl" href="#">PayProf</a>
    </div>


    
    
    <div class="navbar-end" >

      <label class="swap swap-rotate mx-2 ">
      <input type="checkbox" />
        <svg class="swap-on fill-current w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>
        <svg class="swap-off fill-current w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
    </label>

      <button class="btn btn-ghost btn-circle mx-2 " @click="Logout" v-if="IsAuth">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
        </svg>
      </button>
      
    <div class="dropdown dropdown-end" v-if="IsAuth && (this.user.role==0 ||this.user.role==1 || this.user.role==3 )">
  <label @click="showdrop" tabindex="0" class="btn btn-ghost btn-circle avatar">
    <div class="avatar online placeholder">
      <div class="bg-neutral-focus text-neutral-content rounded-full w-10">
        <span class="text-xl">{{ initials }}</span>
      </div>
    </div>
  </label>
  <div  v-show="dropdownOpen" class="absolute right-0 mt-2 rounded-md shadow-lg overflow-hidden z-20 card w-96 bg-neutral  text-primary-content">
  <div class="card-body">
    <h2 class="card-title">M/Mme : {{ this.User.nom }} {{ this.User.prenom }}</h2>
    <p>Email : {{ this.User.email }}</p>
      <p>Role : {{ getRole }}</p>
<!--    <div class="card-actions justify-end">-->
<!--      <button class="btn">Change Password </button>-->
<!--    </div>-->
  </div>
</div>
</div>
    </div>
      </div>
  <Etabs ref="etabsComponent" v-if="false" />
</template>

<script>
import router from '../router';
import store from '../store.js';
import Etabs from '../views/TablesUAE/TableEtablissements.vue';
import {mapActions,mapState} from "vuex";
import axios from "axios";

export default {
  name: 'Header',
 data(){
return{
  dropdownOpen:false,

  User:{
   nom:"",
   prenom:"" 
  },
}
 },
  components: {
    Etabs,
  },
  props: {
    title: String,
  },
  methods: {
    async GetProfile(){
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/profil/'+store.state.user.id+'/info',config);
        this.User=response.data.data;
        console.log(response)

      }
      catch(error){
        console.log(error)
      }
    },


    ...mapActions([
       'logout'
    ]),
    
    showdrop(){
      this.dropdownOpen=!this.dropdownOpen;
    },
   


    //redirect to table des enseingants
    toggleSide() {
      this.showSide = !this.showSide
    },


    
    async Logout(){
      this.$store.dispatch('logout');
    }
  },
  computed: {
    ...mapState(['user']),
    initials() {
      if (this.User && this.User.prenom && this.User.nom) {
        const firstLetter = this.User.prenom.charAt(0);
        const lastLetter = this.User.nom.charAt(0);
        return `${firstLetter}${lastLetter}`;
      }
      return '';
    },
    IsAuth(){
      return store.state.user.token;
    },
    getRole() {

  if (this.user.role) {
    switch (this.user.role) {
      case '0' :
        return 'Enseignant';
      case '1' :
        return 'Directeur';
      case '2' :
        return 'Admin';
      case '3' :
        return 'Directeur UAE';
      case '4' :
        return 'Super Admin';
      default:
        return 'Unknown Role';
    }
  }
},

  },

  // async mounted() {
  //   await this.GetProfile();
  // }
};
</script>
