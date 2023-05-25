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
        <th>Email Personnel</th>
        <th>Prénom</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(Admin, id) in this.Admins" :key="id">
          <td></td>
          <td>{{ Admin.PPR }}</td>
          <td>{{ Admin.Nom }}</td>
          <td>{{ Admin.Prenom }}</td>
          <td>{{ Admin.Telephone }}</td>
          <td>{{ Admin.Etablissement }}</td>
          <td>{{ Admin.Email }}</td>
          <td>
            <button class="add-btn px-2" @click="showPopupForm = true">
              <i class="fas fa-eye" ></i>
              <span class="tooltip" data-tooltip="inspect"></span>
            </button>
          </td>
        </tr> 
      
    </tbody>
  </table>
</div>

<button class="btn btn-outline btn-success ">Ajouter un admin</button>
  
  
</template>

<script>
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
        axios.get('http://127.0.0.1/api/Admins').then(result => {
          this.Admins = result.data
        })
        console.log(response.data)
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