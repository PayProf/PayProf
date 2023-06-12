<template>
  <!-- TABLE ETABLISSEMENT -->
  <div class="overflow-x-auto border">
    <table class="table w-screen botrder">
      <!-- head -->
      <thead>
        <tr>
          <th></th>
          <th>Code</th>
          <th>Nom</th>
          <th>Télephone</th>
          <th>Fax</th>
          <th>Nombre enseignants</th>
          <!-- Consulter la table des enseignants de cet etablissement -->
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(Etablissement, id) in this.Etablissements.data" :key="id">
          <td>{{ Etablissement.id }}</td>
          <td>{{ Etablissement.code }}</td>
          <td>{{ Etablissement.Nom }}</td>
          <td>{{ Etablissement.Telephone }}</td>
          <td>{{ Etablissement.ville }}</td>
          <td>{{ Etablissement.Nombre_des_enseignants }}</td>
          <td>
            <router-link :to="{ path: '/EditEtablissement/'+Etablissement.id }" v-if="Userrole === 4">
              <button class="add-btn px-4" >
              <i class="fas fa-pen" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
            </router-link>

            <button class="add-btn px-4" @click="deleteEtablissement(Etablissement.id)" v-if="Userrole === 4">
              <i class="fas fa-trash" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
            <!-- This page isn't created yet !!!! -->
            <router-link :to="{ path: '/Etablissement/'+Etablissement.id }">
              <button class="add-btn px-4" >
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-outline btn-secondary  ml-5 mt-2 text-black" @click="redirectAdd()" v-if="Userrole === 4">Add etablissement</button>
  </div>
<AddEtablissement v-if="openAdd"/>
</template>

<script>
import store from '../../store';
import axios from 'axios';
import AddEtablissement from '../../components/AddEtablissement.vue';
export default {
  components:{
    AddEtablissement
  },
  name: 'TableEtablissement',
  data() {
    return {
      Etablissements: [],
      Userrole:store.state.user.role,
      openAdd:false
    }
  },

  mounted() {

    this.getEtablissements();
    console.log('test axios')

  },
  methods: {
    async getEtablissements() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('http://127.0.0.1:8000/api/etablissements',config).then(result=>{
          console.log('test axios')
          this.Etablissements = result.data
        })
        console.log(this.Etablissements)
      }
      catch (error) {
        console.log(error)
      }
    },
    deleteEtablissement(EtablissementId){
      const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
      axios.delete(`http://127.0.0.1:8000/api/etablissements/${EtablissementId}`,config)
      .then(res=>{
        console.log(res.data)
        this.getAdmins()
      })
    },
    redirectAdd(){
      this.openAdd = !this.openAdd
    }
  },
 
}
</script>

<style></style>