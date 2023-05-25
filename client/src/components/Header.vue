<template>
  <div class="navbar bg-base-100 fixed top-0 w-full z-10 drop-shadow-md mb-10">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
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
      <button class="btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
        </svg>
      </button>
      
    </div>
    <div class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img src="/images/stock/photo-1534528741775-53994a69daeb.jpg" />
        </div>
      </label>
        <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4">
          <li>Nom Prénom</li> 
          <li>Email</li>
          <router-link :to="{name:'EditProfile'}"> <li><a href="">Editer le profile</a></li> </router-link>
        </ul>
      </div>
  </div>
  <Etabs ref="etabsComponent" v-if="false" />
</template>

<script>
import router from '../router';
import Etabs from '../views/TablesUAE/TableEtablissements.vue';

export default {
  name: 'Header',
  components: {
    Etabs,
  },
  props: {
    title: String,
  },
  methods: {


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
  },
};
</script>
