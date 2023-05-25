<template>
   <div class="overflow-x-auto ml-20 ">
          <table class="table table-zebra w-80 border border-slate-500 ">
            <!-- head -->
            <thead>
              <tr>
                <th></th>
                <th>ID</th>
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
</template>

<script>
export default {
  name: 'Interventions',
  data() {
    return {
      showProfile: true,
      showTable: false ,
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

</style>