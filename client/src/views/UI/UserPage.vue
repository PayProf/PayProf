<template>
  <div class="relative flex min-h-screen ">
    <!-- Main Content -->
    <div class="flex-1">
      <!-- header -->
      <div class="bg-white shadow px-2 py-4  flex-row ">
        <button @click="showSidebar = !showSidebar" class="text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
          </svg>

        </button>
        <h1 class="text-gray-800 text-xl font-bold ml-2  text-center">PayProf</h1>
      </div>
      <!-- body -->
      <div class="hero min-h-screen bg-base-200" v-show="showProfile">
        <div class="hero-content flex-col lg:flex-row ">
          <div>
            <h1 class="text-5xl font-bold">Nom Prénom</h1>
            <p class="py-2">Email</p>
            <p class="py-2">Grade</p>
            <p class="py-2">PPR: #</p>
            <p class="py-2">Etablissement</p>
            <button class="btn btn-primary" @click="showProfile = !showProfile; showTable = !showTable">Voir
              intérvention</button>
          </div>
        </div>
      </div>
      <!------------------------------------------------------------------ TABLE INTERVENTIONS ------------------------------------------------------->
      <div v-show="showTable">
        <h1 class="text-5xl font-bold ">Table d'intérvention</h1>
        <div class="overflow-x-auto ml-20 ">
          <table class="table table-zebra w-80 border border-slate-500 ">
            <!-- head -->
            <thead>
              <tr>
                <th></th>
                <th>PPR</th>
                <th>Etablissement</th>
                <th>Ville</th>
                <th>Intetule Intervention</th>
                <th>Année universitaire</th>
                <th>Semestre</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Nombre d'heure</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(Intervention) in Interventions" :key="Intervention.Id_Intr">
                <td><input type="checkbox" /></td>
                <td>{{ Intervention.Id_Intr }}</td>
                <td>{{ Intervention.Etablisment }}</td>
                <td>{{ Intervention.Intitule_Intervention }}</td>
                <td>{{ Intervention.Annee_universitaire }}</td>
                <td>{{ Intervention.Semester }}</td>
                <td>{{ Intervention.Date_Debut }}</td>
                <td>{{ Intervention.Date_Fin }}</td>
                <td>{{ Intervention.Nombre_heures }}</td>
                <td>
                  <button class="delete-btn">
                    <i class="fas fa-trash"></i>
                    <span class="tooltip" data-tooltip="Delete">Supprimer Intervention </span>
                  </button>
                  <button class="inspect-btn">
                    <i class="fas fa-edit"></i>
                    <span class="tooltip" data-tooltip="Inspect">modify Intervention </span>
                  </button>
                  <button class="btn btn-danger btn-sm">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="btn-group">
          <button class="btn">1</button>
          <button class="btn btn-active">2</button>
          <button class="btn">3</button>
          <button class="btn">4</button>
        </div>

      </div>
    </div>
    <!--  -->

  </div>
</template>

<script setup>
import { ref } from "vue"
export  {
  name: 'Interventions',
  data() {
    return {
      showProfile=true,
      showTable=false ,
      Intervention: []
    }
  },

  mounted() {

    this.getInterventions();
    console.log('test axios')

  },
  methods: {
    async getInterventions() {
      try {
        axios.get('http://127.0.0.1/api/Interventions').then(result => {
          this.Interventions = result.data
        })
        console.log(response.data)
      }
      catch (error) {
        console.log(error)
      }
    }
  },



}
</script>

<style>
.text-5xl {
  margin-top: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.table {
  margin-top: 3%;
  margin-left: 5%;

}

.btn-group {
  margin-top: 3%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>