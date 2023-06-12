<template>
   <div class="overflow-x-auto">
    <table class="table table-zebra w-full">
            <!-- head -->
            <thead>
              <tr>
                <th class="z-30">PPR</th>
                <th>Etablissement</th>
                <th>Intitule Intervention</th>
                <th>Année universitaire</th>
                <th>Semestre</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Nombre Heures</th>
                <th>Visa UAE</th>
                <th>Visa Etab</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(Intervention,id) in Interventions" :key="id">
                <td>{{ Intervention.enseignant.PPR }}</td>
                <td>{{ Intervention.etablissement.nom}}</td>
                <td>{{ Intervention.intitule_intervention}}</td>
                <td>{{ Intervention.annee_univ }}</td>
                <td>{{ Intervention.semestre }}</td>
                <td>{{ Intervention.date_debut }}</td>
                <td>{{ Intervention.date_fin }}</td>
                <td>{{ Intervention.Nbr_heures }}</td>
                <td> <input type="checkbox" :checked="Intervention.visa_uae" class="checkbox" />  </td>
                <td> <input type="checkbox" :checked="Intervention.visa_etab" class="checkbox"  /> </td>
                <td>
                  <button class="add-btn px-4" v-if="this.role==2" >
                    <i class="fas fa-pen" ></i>
                    <span class="tooltip" data-tooltip="inspect">modifier</span>
                  </button>

                  <button class="add-btn px-4" @click="deleteEnseignant(Enseignant.id)" v-if="this.role==2">
                    <i class="fas fa-trash" ></i>
                    <span class="tooltip" data-tooltip="inspect">supprimer</span>
                  </button>
                  <!-- This page isn't created yet !!!! -->
                    <button class="add-btn px-4"  >
                      <i class="fas fa-eye" ></i>
                      <span class="tooltip" data-tooltip="inspect"> inspecter </span>
                    </button>
                </td>
              </tr>
            </tbody>
          </table>
   </div>
           <div class="flex justify-center items-center p-5">
             <v-pagination
                 v-model="page"
                 :pages="pagecount"
                 :range-size="1"
                 active-color="#1d774d"
                 @update:modelValue="getInterventions"
             />
           </div>
     <div class="flex justify-center items-center">
            <AddIntervention/>
     </div>


</template>

<script>
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import axios from "axios";
import store from "../../store.js";
import AddIntervention from "../../components/AddIntervention.vue";
export default {
  name: 'Interventions',
  components:{
    AddIntervention,
    VPagination,
  },
  data() {
    return {
      Interventions: [],
      role:store.state.user.role,
      page:1,
      pagecount:null,
    }
  },

  async mounted() {

    await this.getInterventions();

  },
  methods: {
    async getInterventions() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.get('http://127.0.0.1:8000/api/Intervention/int/ShowMyEtabInterventions?page='+this.page,config)
        this.Interventions=response.data.data
        this.pagecount=response.data.last_page
      }
      catch (error) {
        console.log(error)
      }
    }
  },

}
</script>

<style>

</style>