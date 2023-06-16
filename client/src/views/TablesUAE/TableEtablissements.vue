<template>
  <!-- TABLE ETABLISSEMENT -->
  <div v-if="!Loading" class="mt-0">
  <div class="overflow-x-auto" >
<!--    <h1 class="text-black font-bold text-xl">Table etablissements :</h1>-->
    <table class="table table-zebra w-full z-10">
      <!-- head -->
      <thead class="bg-slate-400">
      <tr>
        <th></th>
        <th>Code</th>
        <th>Nom</th>
        <th>Télephone</th>
        <th>Fax</th>
        <td>Ville</td>
        <th>Nombre enseignants</th>
        <!-- Consulter la table des enseignants de cet etablissement -->
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(Etablissement, id) in this.model.Etablissements.data" :key="id">
        <td>{{ id + 1 }}</td>
        <td><div v-if="!IsRow(Etablissement.id)">{{ Etablissement.code }}</div><div v-else><input type="number" :placeholder="Etablissement.code" v-model="this.UpdatedEtablissement.code" class="input input-ghost w-full max-w-xs" disabled/></div></td>
        <td><div v-if="!IsRow(Etablissement.id)">{{ Etablissement.nom }}</div><div v-else><input type="text" :placeholder="Etablissement.nom" v-model="this.UpdatedEtablissement.nom" class="input input-ghost w-full max-w-xs" required/></div></td>
        <td><div v-if="!IsRow(Etablissement.id)">{{ Etablissement.telephone }}</div><div v-else><input type="number" :placeholder="Etablissement.telephone" v-model="this.UpdatedEtablissement.telephone" class="input input-ghost w-full max-w-xs" required min="0"/></div></td>
        <td><div v-if="!IsRow(Etablissement.id)">{{ Etablissement.FAX }}</div><div v-else><input type="number" :placeholder="Etablissement.FAX" v-model="this.UpdatedEtablissement.FAX" class="input input-ghost w-full max-w-xs" required min="0"/></div></td>
        <td><div v-if="!IsRow(Etablissement.id)">{{ Etablissement.ville }}</div><div v-else><input type="text" :placeholder="Etablissement.ville" v-model="this.UpdatedEtablissement.ville" class="input input-ghost w-full max-w-xs" disabled/></div></td>
        <td><div v-if="!IsRow(Etablissement.id)">{{ Etablissement.Nbrenseignants }}</div><div v-else><input type="number" :placeholder="Etablissement.Nbrenseignant" v-model="this.UpdatedEtablissement.Nbrenseignant" class="input input-ghost w-full max-w-xs"  disabled/></div></td>
        <td>

          <button class="add-btn px-4" v-if="Userrole==4" @click="this.SelectedId = Etablissement.id" >
            <i class="fas fa-pen" v-if="!IsRow(Etablissement.id)"></i>
            <i class="fas fa-check" v-else @click="ConfirmEdit(Etablissement.id)"></i>
            <span class="tooltip" data-tooltip="inspect">modifier</span>
          </button>

          <router-link :to="{ path: '/Etablissement/'+Etablissement.id }">
            <button class="add-btn px-4" >
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
          </router-link>

          <button class="add-btn px-4" @click="deleteEtablissement(Etablissement.id)" v-if="Userrole == 4">
            <i class="fas fa-trash" ></i>
            <span class="tooltip" data-tooltip="inspect"></span>
          </button>
          <!-- This page isn't created yet !!!! -->

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
          @update:modelValue="getEtablissements"
      />
    </div>

  </div>
  <AddEtablissement v-if="this.Userrole==4"/>
  </div>

</template>

<script>
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import store from '../../store';
import axios from 'axios';
import AddEtablissement from '../../components/AddEtablissement.vue';
export default {
  components:{
    AddEtablissement,
    VPagination
  },
  name: 'TableEtablissement',
  data() {
    return {
      model:{
        Etablissements: [{
          nom:'',
          code:'',
          telephone:'',
          FAX:'',
          ville:'',
          Nbrenseignants:''
        }],
      },
      UpdatedEtablissement:{},
      SelectedId:null,
      Userrole:store.state.user.role,
      pagecount:null,
      page:1,
      openAdd:false,
      Loading:false,
    }
  },

  async mounted() {
    this.Loading=true;
    await this.getEtablissements();
    this.Loading=false;

  },
  methods: {
    IsRow(id) {
      return id == this.SelectedId;
    },
    async ConfirmEdit(id) {
      try {
        const token = store.state.user.token;
        const config = {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json',
          }
        };

        await axios.patch(
            `http://127.0.0.1:8000/api/etablissements/${id}`,
            this.UpdatedEtablissement, // Pass the object in the request payload
            config
        );
        this.SelectedId = null;
        await this.getEtablissements();
      } catch (error) {
        console.log(error);
      }
    },
    async getEtablissements() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('http://127.0.0.1:8000/api/etablissements?page='+this.page,config).then(result=>{
          this.model.Etablissements = result.data.data
          this.pagecount = result.data.data.last_page;
        })

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
            this.getEtablissements()
          })
    },

    redirectAdd(){
      this.openAdd = !this.openAdd
    }
  },

}
</script>

<style></style>