<template>
  <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12">
    <div class="col-span-1">
      <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-50" v-drag>
        <li @click="toggleTableEnseignant()" v-if="showDir" class="bg-neutral text-white">
          <i class="fa-solid fa-user-tie"></i>
        </li>
        <li @click="toggleTableEnseignant()" v-else>
          <i class="fa-solid fa-user-tie"></i>
        </li>
        <li @click="toggleTableIntervention()" v-if="showEtablissement" class="bg-neutral text-white">
          <i class="fa-solid fa-chalkboard-user"></i>
        </li>
        <li @click="toggleTableIntervention()" v-else>
          <i class="fa-solid fa-chalkboard-user"></i>
        </li>
        <li>
          <i class="fa-solid fa-arrows-up-down-left-right"></i>
        </li>
      </ul>
    </div>
    <div class="col-span-11">
      <div class="card card-side bg-base-100 shadow-xl  mx-64">
        <div class="card-body">
          <h1 class="text-2xl font-bold">Etablissement {{ Etablissements.nom }}</h1>
          <p class="py-2"><strong>Nom :</strong>{{ this.Etablissements.code }}</p>
          <p class="py-2"><strong>Ville:</strong> {{ this.Etablissements.ville }}</p>
          <p class="py-2"><strong>Telephone :</strong> {{ this.Etablissements.Telephone }}</p>
          <p class="py-2"><strong>Fax :</strong> {{ this.Etablissements.FAX }}</p>
          <p class="py-2"><strong>Nombre Enseignant :</strong> {{ this.Etablissements.Nombre_des_enseignants }}</p>
        </div>
      </div>
      <div class=" mt-3">
        <TableEnseignantUAE v-if="showEns"/>
        <ValidateInterventionUAE  v-if=" UserRole == 3 && showInt" />
      </div>

    </div>
  </div>




</template>

<script >
import ValidateInterventionUAE from '../TablesUAE/ValidateInterventionUAE.vue';
import TableEnseignantUAE from '../TablesUAE/TableEnseignant.vue'
import store from "../../store"
import axios from 'axios';


export default {
  data() {
    return {
      EtablissementId: "",
      Etablissements: [],
      UserRole:store.state.user.role,
      showEns:true,
      showInt:false
    }


  },
  components: {
    TableEnseignantUAE,
    ValidateInterventionUAE
  },
  async mounted() {
    await this.getEtablissement();
    // await this.getProfile();
  },
  methods: {
    async getEtablissement() {
      try {
        this.EtablissementId = this.$route.params.id;
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('http://127.0.0.1:8000/api/etablissements/' + this.$route.params.id, config).then(result => {
          this.Etablissements = result.data.data
        })

      }
      catch (error) {
        console.log(error)
      }
    },
    toggleTableEnseignant(){
      this.showEns = !this.showEns
    },
    toggleTableIntervention(){
      this.showInt = !this.showInt
    }


  }

}
</script>

<style>
.card {
  margin-top: 10%;
}
</style>