<template>
  <div class="overflow-x-auto  z-10">
    <h1 class="text-black font-bold text-xl">Table Directeurs :</h1>
    <table class="table table-zebra w-full z-10">
      <!-- head -->
      <thead>
        <tr>
          <th></th>
          <th>PPR</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Etablissement</th>
          <th>Email Personnel</th>
          <th>Date Naissance</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(Directeur,index) in this.Directeurs" :key="index">
          <td>{{ Directeur.id }}</td>
          <td>{{ Directeur.PPR }}</td>
          <td>{{ Directeur.nom }}</td>
          <td>{{ Directeur.prenom }}</td>
          <td>{{ Directeur.NomEtab }}</td>
          <td>{{ Directeur.Email }}</td>
          <td>{{ Directeur.DateNaissance }}</td>
          <td>
              <button class="add-btn px-4">
                <i class="fas fa-pen"></i>
                <span class="tooltip" data-tooltip="inspect"></span>
              </button>
            <button class="add-btn px-4" @click="deleteDirecteur(Directeur.id)" v-if="this.Userrole == 2">
              <i class="fas fa-trash"></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>

          <!-- The error here was caused by route-link it had no link, add it before uncomment-->

            <router-link :to="{ path: '/Etablissement/'+Directeur.NomEtab }"> <!-- Youssef has to send id_etablissement in addition to nometab make this  -->
              <button class="add-btn px-4" >
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
            </router-link>


          </td>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-center items-center p-5">
      <v-pagination
          v-model="page"
          :pages="pagecount"
          :range-size="1"
          active-color="#1d774d"
          @update:modelValue="getDirecteurs"
      />
    </div>
  </div>
  <AddDirecteur v-if="this.Userrole == 2" />
</template>

<script>
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import axios from 'axios';
import store from "../../store.js";
import AddDirecteur from '../../components/AddDirecteur.vue';

export default {
  data() {
    return {
      Directeurs:[],
      Userrole:store.state.user.role,
      openAdd:false,
      pagecount:null,
      page:1,
    }
  },
  components:{
    AddDirecteur,
    VPagination
  },
  async mounted() {
    await this.getDirecteurs();
  },
  methods: {
    async getDirecteurs() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('http://127.0.0.1:8000/api/Directeur?page='+this.page,config).then(result => {
          this.pagecount = result.data.data.last_page;
          this.Directeurs = result.data.data
          console.log(this.Directeurs)
        })
      }
      catch (error) {
        console.log(error)
      }
    },

    RedirectAdd() {
      this.openAdd = !this.openAdd
    },

    deleteDirecteur(DirecteurId){
      const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
      axios.delete(`http://127.0.0.1:8000/api/Directeur/${DirecteurId}`,config)
      .then(res=>{
        console.log(res.data)
        this.getDirecteurs()
      })
    }
  }

}
</script>

<style></style>