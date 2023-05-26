<template>

    <h1 class="text-5xl font-bold mt-24 text-gray-700 ">Table admins</h1>
    <div class="overflow-x-auto border">
  <table class="table w-screen botrder">
    <!-- head -->
    <thead>
      <tr >
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
      <tr v-for="(Admin, id) in this.Admins.data" :key="id">
          <td>{{ id + 1 }}</td>
          <td>{{ Admin.PPR }}</td>
          <td>{{ Admin.nom }}</td>
          <td>{{ Admin.prenom }}</td>
          <td>{{ Admin.etablissement_id }}</td>
          <td>{{ Admin.email_perso }}</td>
          <td>
            <button class="add-btn px-2" >
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
          </td>
        </tr>  
    </tbody>
  </table>
</div>

<button class="btn btn-outline btn-success" @click="RedirectAdd()" >Ajouter un admin</button>
  
</template>

<script>
import axios from 'axios';
export default {
    name: 'EtabAdmins',
    data() {
    return {
      Admins: []
    }
  },

  mounted() {

    this.getAdmins();
    console.log('test axios')

  },
  methods: {
    async getAdmins() {
      try {
        await axios.get('http://127.0.0.1:8000/api/admins').then(result => {
          this.Admins = result.data
        })
        console.log(this.Admins.data)
      }
      catch (error) {
        console.log(error)
      }
    },
    RedirectAdd() {
      this.$router.push('/AddAdmin')
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