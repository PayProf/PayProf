<template>
  <div>
    <button class="btn btn-primary rounded mb-4" @click="showPopup = true">ADD</button>
    <div v-if="showPopup" class="popup">
      <div class="popup-content card w-96 bg-neutral ">
        <div class="card-body items-center text-center">
          <h2 class="card-title">Add Intervention</h2>
          <form @submit.prevent="saveIntervention(); showPopup = false">
            <!-- Form fields fogr addin an intervention -->
            <div class="grid grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Code</span>
                </label>
                <input type="text" v-model="model.Intervention.Code" placeholder="Code" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Etablissement</span>
                </label>
                <input type="text" v-model="model.Intervention.Etablissement" placeholder="Etablissement"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Ville</span>
                </label>
                <input type="text" v-model="model.Intervention.Ville" placeholder="Ville" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Intitule Intervention</span>
                </label>
                <input type="text" v-model="model.Intervention.Intitule" placeholder="Intitule"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Année universitaire</span>
                </label>
                <input type="text" v-model="model.Intervention.Annee" placeholder="Année universitaire"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Semestre</span>
                </label>
                <select v-model="model.Intervention.Semestre" class="select select-bordered">
                  <option value="1">1st Semester</option>
                  <option value="2">2nd Semester</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label">
                  <!-- l -->
                  <span class="label-text">Date début</span>
                </label>
                <input type="date" v-model="model.Intervention.DateDebut" placeholder="Date début"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Date fin</span>
                </label>
                <input type="date" v-model="model.Intervention.DateFin" placeholder="Date fin"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Nombre d'heure</span>
                </label>
                <input type="text" v-model="model.Intervention.NombreHeures" placeholder="Nombre d'heure"
                  class="input input-bordered" />
              </div>
              <div class="form-control col-span-2">
                <label class="label">
                  <span class="label-text">Visa_etb</span>
                </label>
                <input type="checkbox" v-model="model.Intervention.Checkbox1" class="checkbox checkbox-primary" />
              </div>
              
            </div>

            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary rounded" style="margin-bottom: 5px;">
                Add Intervention
              </button>
              <button type="button" class="btn btn-primary rounded" @click="showPopup = false">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import axios from 'axios';
export default {
  name: 'AddIntervention',
  data() {
    return {
      showPopup: false,
      model: {
        Intervention: {
          Code: '',
          Etablissement: '',
          Ville: '',
          Intitule: '',
          Annee: '',
          Semestre: '',
          DateDebut: '',
          DateFin: '',
          NombreHeures: '',
          Checkbox1: false,
          Checkbox2: false
        }
      }
    };
  },
  methods: {
    saveIntervention(){
      const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
      axios
        .post('http://127.0.0.1:8000/api/Intervention', this.model.Intervention,config)
        .then(result => {
          console.log(result.data);
          this.model.Intervention = {
            Code: '',
            Etablissement: '',
            Ville: '',
            Intitule: '',
            Annee: '',
            Semestre: '',
            DateDebut: '',
            DateFin: '',
            NombreHeures: '',
            Checkbox1: false,
            Checkbox2: false
          };
        })
        .catch(error => {
          if (error.response) {
            if (error.response.status == 422) {
              this.errorsList = error.response.data.errors;
            }
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log('Error', error.message);
          }
        });
    }
  }
};
</script>

<style>
.popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.popup-content {
  background-color: #fff;
  padding: 20px;
}
</style>
