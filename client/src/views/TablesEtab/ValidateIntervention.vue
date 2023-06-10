<template>
   <div class="overflow-x-auto ml-20 ">
    <table class="table table-zebra w-full  ">
            <!-- head -->
            <thead>
              <tr>
                <th></th>
                <th>PPR</th>
                <th>Etablissement</th>
                <th>Intetule Intervention</th>
                <th>Année universitaire</th>
                <th>Semestre</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Visa UAE</th>
                <th>Visa Etab</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(Intervention,id) in Interventions.data" :key="id">
                <td>{{ Intervention.PPRProf }}</td>
                <td>{{ Intervention.Id_Intr }}</td>
                <td>{{ Intervention.NomEtab}}</td>
                <td>{{ Intervention.IntituleIntervention}}</td>
                <td>{{ Intervention.AnneeUniv }}</td>
                <td>{{ Intervention.Semestre }}</td>
                <td>{{ Intervention.DateDebut }}</td>
                <td>{{ Intervention.DateFin }}</td>
                <td>{{ Intervention.Nombre_heures }}</td>
                <td> <input type="checkbox" checked="checked" class="checkbox" disabled />  </td>
                <td> <input type="checkbox" checked="checked" class="checkbox" /> </td>
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
</template>

<script>
import axios from "axios";
export default {
  name: 'Interventions',
  data() {
    return {
      Interventions: []
    }
  },

  mounted() {

    this.getInterventions();
    console.log('test axios')

  },
  methods: {
    async getInterventions() {
      try {
        axios.get('http://127.0.0.1:8000/api/Intervention').then(result => {
          this.Interventions = result.data
        })
        console.log(this.Interventions.data)
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