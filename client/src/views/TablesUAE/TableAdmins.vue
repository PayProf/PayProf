<template>

<h1 class="text-black font-bold text-xl">Table Admins :</h1>
    <div class="overflow-x-auto border">
  <table class="table w-screen border z-10">
    <!-- head -->
    <thead>
      <tr>
        <th></th>
        <th>PPR</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Etablissement</th>
        <th>Email Personnel</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(Admin, id) in this.model.Admins.data" :key="id">
        <td>{{ id + 1 }}</td>
        <td><div v-if="!IsRow(Admin.id)">{{ Admin.PPR }}</div><div v-else><input type="text" :placeholder="Admin.PPR" v-model="this.UpdatedAdmin.PPR" class="input input-ghost w-full max-w-xs" disabled/></div></td>
        <td><div v-if="!IsRow(Admin.id)">{{ Admin.nom }}</div><div v-else><input type="text" :placeholder="Admin.nom" v-model="this.UpdatedAdmin.nom" class="input input-ghost w-full max-w-xs" disabled/></div></td>
        <td><div v-if="!IsRow(Admin.id)">{{ Admin.prenom }}</div><div v-else><input type="text" :placeholder="Admin.prenom" v-model="this.UpdatedAdmin.prenom" class="input input-ghost w-full max-w-xs" disabled/></div></td>
        <td><div v-if="!IsRow(Admin.id)">{{ Admin.etablissement_id }}</div><div v-else><input type="text" :placeholder="Admin.etablissement_id" v-model="this.UpdatedAdmin.etablissement_id" class="input input-ghost w-full max-w-xs" disabled/></div></td>
        <td><div v-if="!IsRow(Admin.id)">{{ Admin.email_perso }}</div><div v-else><input type="text" :placeholder="Admin.email_perso" v-model="this.UpdatedAdmin.email_perso" class="input input-ghost w-full max-w-xs" /></div></td>
          
          <td>
            <button class="add-btn px-4" v-if="Userrole==4" @click="this.SelectedId = Admin.id" >
              <i class="fas fa-pen" v-if="!IsRow(Admin.id)"></i>
              <i class="fas fa-check" v-else @click="ConfirmEdit(Admin.id)"></i>
              <span class="tooltip" data-tooltip="inspect">modifier</span>
            </button>
            
            <button class="add-btn px-4" @click="deleteAdmin(Admin.id)">
              <i class="fas fa-trash" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
            <!-- This page isn't created yet !!!! -->
            <router-link :to="{ path: '/Etablissement/'+Admin.etablissement_id }">
              <button class="add-btn px-4" >
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
            </router-link>
            
            
          </td>
        </tr>  
    </tbody>
  </table>
</div>
<AddAdmin />

  
</template>

<script>
import AddAdmin from '../../components/AddAdmin.vue';
import store from '../../store';
import axios from 'axios';
export default {
    name: 'EtabAdmins',
    components:{
      AddAdmin
    },
    data() {
    return {
      model:{
        Admins:[{
          PPR:'',
          nom:'',
          prenom:'',
          etablissement_id:'',
          email_perso:''
        }]
      },
      UpdatedAdmin:{},
      SelectedId:null,
      openAdd:false,
      Userrole:store.state.user.role
    }
  },

  mounted() {

    this.getAdmins();
    console.log('test axios')

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
            `http://127.0.0.1:8000/api/admins/${id}`,
            this.UpdatedAdmin, // Pass the object in the request payload
            config
        );
        this.SelectedId = null;
        await this.getAdmins();
      } catch (error) {
        console.log(error);
      }
    },
    async getAdmins() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('http://127.0.0.1:8000/api/admins',config).then(result => {
          this.model.Admins = result.data
          console.log(result.data)
        })
        console.log(this.model.Admins.data)
      }
      catch (error) {
        console.log(error)
      }
    },
    RedirectAdd() {
      this.openAdd = !this.openAdd
    },
    deleteAdmin(AdminId){
      const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
      axios.delete(`http://127.0.0.1:8000/api/admins/${AdminId}`,config)
      .then(res=>{
        console.log(res.data)
        this.getAdmins()
      })
    }
  }
   
}
</script>

<style>
table{
   margin-top: 10% ;
}
.button{
    margin-top: 10% ;
    padding-right: 5%;
}
</style>