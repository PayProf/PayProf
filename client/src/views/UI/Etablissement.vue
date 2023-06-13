<template>
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
  <TableEnseignant />
</template>

<script >
import TableEnseignant from '../TablesUAE/TableEnseignant.vue'
import store from "../../store"
import axios from 'axios';


export default {
  data() {
    return {
      EtablissementId: "",
      Etablissements: [],
    }


  },
  components: {
    TableEnseignant
  },
  async mounted() {
    await this.getEtablissement();
    await this.getProfile();
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
    async getProfile(){  
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('http://127.0.0.1:8000/api/admins/' + this.$route.params.id+'/myprofile/', config).then(result => {
          this.Etablissements = result.data.data
          console.log(result)
        })

      }
      catch (error) {
        console.log(error)
      }
    }
  }

}
</script>

<style>
.card {
  margin-top: 10%;
}
</style>