<template>
  <div class="mt-10">
    <table class="table table-zebra w-full ">
      <!-- head -->
      <thead>
      <tr>
        <th>PPR</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Grade</th>
        <th>Email</th>
        <th>Date naissance</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(Enseignant,index) in this.model.Enseignants" :key="index">

        <td>{{Enseignant.PPR}}</td>
        <td>{{ Enseignant.nom }}</td>
        <td>{{ Enseignant.prenom }}</td>
        <td>{{ Enseignant.Grade }}</td>
        <td>{{ Enseignant.Email}}</td>
        <td>{{ Enseignant.DateNaissance }}</td>
        <td>
          <!-- This page isn't created yet !!!! -->
          <router-link :to="{ path: '/ADuser/'+Enseignant.id }">
            <button class="add-btn px-4"  v-if="user.role==2 ||user.role==4||user.role==3||user.role==1">
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"> inspecter </span>
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
          @update:modelValue="getEnseignantsEtab"
      />
    </div>
    <div class="flex justify-center">
    <AddEnseignant/>
    </div>
  </div>



</template>

<script>
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import store from '../../store'
import axios from 'axios';
import { mapActions, mapState } from 'vuex';
import AddEnseignant from '../../components/AddEnseignant.vue';
export default {
  name: 'TableEnseignants',
  components:{
    AddEnseignant,
    VPagination,

  },
  data() {
    return {
      model:{
        Enseignants:[{
          id:'',
          nom:'',
          prenom:'',
          grade:{},
          date_naissance:'',
          email_perso:'',
          PPR:'',

        }],



      } ,
     

    }
  },
  computed: {
    ...mapState([
      'enseignants',
      'user'
    ])
  },
  methods: {

    async getEnseignantsEtab() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const res = await axios.get('http://127.0.0.1:8000/api/etablissements/'+this.$route.params.id+'?with=Enseignants',config)
        this.model.Enseignants=res.data.data.Enseignants;
        this.pagecount=res.data.data.last_page;
        console.log(res)
         } catch (error) {
            console.log(error)
        }
      },
    },
    async mounted() {
     await this.getEnseignantsEtab();
    }
  }
 
  



</script>

<style>
.delete-btn,
.add-btn,
.inspect-btn {
  position: relative;
  display: inline-block;
  padding: 0;
  border: none;
  background: none;
  cursor: pointer;
  margin-right: 10px;

}

.tooltip {
  position: absolute;
  background-color: gray;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  visibility: hidden;
  opacity: 0;
  transition: opacity 0.2s, visibility 0s linear 0.2s;
  pointer-events: none;
  white-space: nowrap;
}

.delete-btn:hover .tooltip,
.add-btn:hover .tooltip,
.inspect-btn:hover .tooltip {
  visibility: visible;
  opacity: 1;
  transition-delay: 0s;
}

.tooltip:before {
  content: attr(data-tooltip);
  position: absolute;
  top: -25px;
  left: 50%;
  transform: translateX(-50%);
}
.search-bar-container {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 10px;
}

.search-bar {
  width: 200px;
  margin-left: 10px;
}

</style>