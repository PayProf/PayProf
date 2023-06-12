<template>
  <div class="mt-10">
    <table class="table table-zebra w-full">
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
        <td>{{ Enseignant.grade_id }}</td>
        <td>{{ Enseignant.email_perso}}</td>
        <td>{{ Enseignant.date_naissance }}</td>
        <td>
          <router-link :to="{ path: '/ADuser/'+Enseignant.id }">
            <button class="add-btn px-4" v-if="user.role==2" >
              <i class="fas fa-pen" ></i>
              <span class="tooltip" data-tooltip="inspect">modifier</span>
            </button>
          </router-link>

          <button class="add-btn px-4" @click="deleteEnseignant(Enseignant.id)" v-if="user.role==2">
            <i class="fas fa-trash" ></i>
            <span class="tooltip" data-tooltip="inspect">supprimer</span>
          </button>
          <!-- This page isn't created yet !!!! -->
          <router-link :to="{ path: '/ADuser/'+Enseignant.id }">
            <button class="add-btn px-4"  >
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
          @update:modelValue="getEnseignants"
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
        Enseignants:{
          id:'',
          nom:'',
          prenom:'',
          Grade:'',
          DateNaissance:'',
          Email:'',

        },


      } ,
      pagecount:null,
      page:1,

    }
  },
  computed: {
    ...mapState([
      'enseignants',
      'user'
    ])
  },
  methods: {
    async getEnseignants() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        const res = await axios.get('http://127.0.0.1:8000/api/admins/'+store.state.user.id+'/showenseignants?page='+this.page,config)
        this.model.Enseignants=res.data.data.data;
        this.pagecount=res.data.data.last_page;


      }
      catch (error) {
        console.log(error)
      }
    },
    // deleteEnseignant(EnseignantId){
    //   axios.delete(`http://127.0.0.1:8000/api/admins/${AdminId}`)
    //   .then(res=>{
    //     console.log(res.data)
    //     this.getAdmins()
    //   })
    // }

  },
  mounted() {
    this.getEnseignants();
  },
};


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