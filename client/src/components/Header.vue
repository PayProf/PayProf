<template>
  <div class="navbar bg-base-100 fixed top-0 w-full z-10 drop-shadow-md mb-10">
    <div class="navbar-start">
      <div class="dropdown">
          <label class="btn btn-circle swap swap-rotate">

          <!-- this hidden checkbox controls the state -->
          <input type="checkbox" />

          <!-- hamburger icon -->
          <svg class="swap-off fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z"/></svg>

          <!-- close icon -->
          <svg class="swap-on fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><polygon points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49"/></svg>

        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li><a @click="toggleProfile()">Profile</a></li>
          <!-- to show them only if he is logged in  -->
          <li><a @click="toggleEtab()">Table etablissment</a></li>
          <li><a @click="toggleAdm()">Table admins</a></li>
          <li><a @click="toggleDir()">table directeurs</a></li>
        </ul>
      </div>
    </div>
    <div class="navbar-center">
      <a class="btn btn-ghost normal-case text-xl" href="https://www.uae.ma/website/node/41">PayProf</a>
    </div>


    <div class="navbar-end">
      <button class="btn btn-ghost btn-circle" @click="Logout">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
        </svg>
      </button>

    </div>

    <div class="dropdown dropdown-end">
  <label @click="showdrop" tabindex="0" class="btn btn-ghost btn-circle avatar">
    <div class="avatar online placeholder">
      <div class="bg-neutral-focus text-neutral-content rounded-full w-10">
        <span class="text-xl">{{ initials }}</span>
      </div>
    </div>
  </label>

  <!-- <div v-show="dropdownOpen" class="absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20" style="width: 20rem;">
    <div class="py-2">
      <p></p>

    </div>
  </div> -->
  <div  v-show="dropdownOpen" class="absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20 card w-96 bg-primary text-primary-content">
  <div class="card-body">
    <h2 class="card-title">M/Mme : {{ user.nom }} {{ user.prenom }}</h2>
    <p>Email : {{ user.email }}</p>
      <p>role : {{ getRole }}</p>
    <div class="card-actions justify-end">
      <button class="btn">Change Password </button>
    </div>
  </div>
</div>
</div>


      </div>

  <!--  -->
  <Etabs ref="etabsComponent" v-if="false" />
</template>

<script>
import router from '../router';
import Etabs from '../views/TablesUAE/TableEtablissements.vue';
import {mapActions,mapState} from "vuex";

export default {
  name: 'Header',
 data(){
return{
  dropdownOpen:false,
}
 },
  components: {
    Etabs,
  },
  props: {
    title: String,
  },
  methods: {
    ...mapActions([
       'logout'
    ]),
    showdrop(){
this.dropdownOpen=!this.dropdownOpen;
    },
   


    //redirect to table des enseingants
    toggleProfile() {
      router.push('/AdminUAE')
    },

    //redirect to table des admins

    toggleAdm() {
      router.push('/EtabAdmins')
    },

    //redirect to table des etablissments
    toggleEtab() {
      router.push('/Etablissements')
    },

    //redirect to table des chef des etablisments
    toggleDir() {
      router.push('/EtabDirecrteurs')
    },

    async Logout(){
      this.$store.dispatch('logout');
    }
  },
  computed: {
    ...mapState(['user']),
    initials() {
      if (this.user && this.user.prenom && this.user.nom) {
        const firstLetter = this.user.prenom.charAt(0);
        const lastLetter = this.user.nom.charAt(0);
        return `${firstLetter}${lastLetter}`;
      }
      return '';
    },
    getRole() {
  if (this.user.role) {
    switch (this.user.role) {
      case 0 :
        return 'Enseignat';
      case 1 :
        return 'Directeur';
      case 2 :
        return 'Admin';
      case 3 :
        return 'Directeur UAE';
      case 4 :
        return 'Super Admin';
      default:
        return 'Unknown Role';
    }
  }
},
  },
};
</script>
