<template>
  <div class="navbar bg-base-100 fixed top-0 w-full z-10">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li><a @click="toggleProfileHeader()">Profile</a></li>
          <!-- to show them only if he is logged in  -->
          <li><a @click="toggleEtabHeader()">Table etablissment</a></li>
          <li><a @click="toggleAdmHeader()">Table admins</a></li>
          <li><a @click="toggleDirHeader()">table directeurs</a></li>
        </ul>
      </div>
    </div>
    <div class="navbar-center">
      <a class="btn btn-ghost normal-case text-xl">PayProf</a>
    </div>
    <div class="navbar-end">
      <button class="btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>
    </div>
  </div>
  <Etabs ref="etabsComponent" v-if="false" />
</template>

<script>
import router from '../router';
import Etabs from '../views/UI/Etabs.vue';

export default {
  name: 'Header',
  components: {
    Etabs,
  },
  props: {
    title: String,
  },
  methods: {
    toggleProfileHeader() {
      this.$refs.etabsComponent.toggleProfile();
    },
    toggleAdmHeader() {
      this.$refs.etabsComponent.toggleAdm();
    },
    toggleEtabHeader() {
      // this.$refs.etabsComponent.toggleEtab();
      router.push('/Enss')
    },
    toggleDirHeader() {
      this.$refs.etabsComponent.toggleDir();
    },
  },
};
</script>
