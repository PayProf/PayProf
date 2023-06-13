<template>

  
  <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12">
    <div class="col-span-1">
      <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-50" v-drag>
        
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
    <div class="col-span-11">
      <TableAdmins v-if="showAdmin" />
      <TableDirecteurs v-if="showDir" />
      <TableEtablissements v-if="showEtablissement"/>
    </div>

  </div>
</template>
 
<script>
import TableAdmins from '../TablesUAE/TableAdmins.vue'
import TableEtablissements from '../TablesUAE/TableEtablissements.vue'
import TableDirecteurs from '../TablesUAE/TableDirecteurs.vue'
export default {
  name: "AdminUAE",
  data() {
    return {
      showAdmin: false,
      showDir: false,

      showEtablissement: true,
      Profile:[],
    }
  },
  components: {
    TableAdmins,
    TableEtablissements,
    TableDirecteurs
  },
  methods: {
    toggleTableAdmin() {
      this.showAdmin = !this.showAdmin
    },
    toggleTableDirecteur() {
      this.showDir = !this.showDir
    },
    toggleTableEtablissement() {
      this.showEtablissement = !this.showEtablissement
    },
    toggleProfile() {
      this.showProfile = !this.showProfile
    },
    async showmyprofile() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/Enseignant/ens/ShowMyProfil', config);
        this.Profile = response.data.data;

      }
      catch (error) {
        console.log(error)
      }
    }

  }
}
</script>
     
<style>
.class{
  margin-top: 10%;
}
</style>