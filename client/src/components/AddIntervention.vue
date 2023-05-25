<template>
  <div class="ml-30 my-20">
    <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100 justify-center">
      <div class="card-body">
        <form>
          <!-- Form fields for adding an enseignant -->
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
              <span class="label-text">Intetule Intervention</span>
            </label>
            <input type="email" v-model="model.Intervention.Intetule" placeholder="Intetule"
              class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Année universitaire</span>
            </label>
            <input type="email" v-model="model.Intervention.Année" placeholder="Année universitaire"
              class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Semestre</span>
            </label>
            <input type="email" v-model="model.Intervention.Semestre" placeholder="Semestre"
              class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Date début</span>
            </label>
            <input type="email" v-model="model.Intervention.Année" placeholder="Année universitaire"
              class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Date début</span>
            </label>
            <input type="email" v-model="model.Intervention.DateD" placeholder="Date début"
              class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Date fin</span>
            </label>
            <input type="email" v-model="model.Intervention.DateF" placeholder="Date fin" class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Nombre d'heure</span>
            </label>
            <input type="email" v-model="model.Intervention.Heures" placeholder="Nombre d'heure"
              class="input input-bordered" />
          </div>

          <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary" style="border-radius: 10px;"
              @click="saveIntervention(), RedirectTable()">Add
              Intervention</button>
            <button class="btn btn-primary" style="border-radius: 10px;">Cancel</button>
          </div>
        </form>
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
      errorsList: "",
      model: {
        Intervention: {
          Code: "",
          Etablissement: "",
          Ville: "",
          Intetule: "",
          Annee: "",
          Semestre: "",
          DateD: "",
          DateF: "",
          Heures: ""
        }
      }
    }
  },

  methods: {
    saveIntervention() {

      var myThis = this;
      axios.post('http://127.0.0.1/api/AddInterventions', this.model.Intervention)
        .then(result => {
          console.log(result.data)
          this.model.Intervention = {
            Code: "",
            Etablissement: "",
            Ville: "",
            Intetule: "",
            Annee: "",
            Semestre: "",
            DateD: "",
            DateF: "",
            Heures: ""
          }

        }).catch(function (error) {

          if (error.response) {

            if (error.response.status == 422) {

              //if you don't specify "myThis" an undefined error will be shown
              myThis.errorsList = error.response.data.errors;
            }

            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
          } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log('Error', error.message);
          }

        });
    },

    //Redirect to table view
    RedirectTable() {
      this.$router.push('/TableInterventions')
    }

  },


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
}</style>