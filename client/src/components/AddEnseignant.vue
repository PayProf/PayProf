<template>
  <div>
    <button class="btn btn-primary rounded mb-4" @click="showPopup = true">ADD</button>
    <div v-if="showPopup" class="popup">
      <div class="popup-content">
        <h2 class="card-title">Add Intervention</h2>
        <form @submit.prevent="saveIntervention(); showPopup = false">
          <!-- Form fields for adding an enseignant -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">PPR</span>
            </label>
            <input type="number" v-model="model.Enseignant.PPR" placeholder="PPR" class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Nom</span>
            </label>
            <input type="text" v-model="model.Enseignant.nom" placeholder="Nom" class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Prénom</span>
            </label>
            <input type="text" v-model="model.Enseignant.prenom" placeholder="Prénom" class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Email</span>
            </label>
            <input type="email" v-model="model.Enseignant.Email" placeholder="Email" class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Grade</span>
            </label>
            <select v-model="model.Enseignant.Grade" class="select select-bordered">
              <option value="">Select Grade</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
            </select>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Date Naissance</span>
            </label>
            <input type="date" v-model="model.Enseignant.DateNaissance" placeholder="Date Naissance" class="input input-bordered" />
          </div>

          <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary" style="border-radius: 10px;" @click="saveEnseignant(), RedirectTable()">Add Enseignant</button>
            <button class="btn btn-primary" style="border-radius: 10px; margin-top: 10px;" @click="showPopup = false">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AddEnseignant',
  data() {
    return {
      showPopup: false,

      errorsList: "",
      model: {
        Enseignant: {
          PPR: "",
          nom: "",
          prenom: "",
          Email: "",
          Grade: "",
          DateNaissance: ""
        }
      }
    }
  },

  methods: {
    showPopup() {
      this.isPopupVisible = !this.isPopupVisible;
    },
    

    saveEnseignant() {
      var myThis = this;
      axios.post('http://127.0.0.1/api/Enseignant', this.model.Enseignant)
        .then(result => {
          console.log(result.data)
          this.model.Enseignant = {
            PPR: "",
            nom: "",
            prenom: "",
            Email: "",
            Grade: "",
            DateNaissance: ""
          }
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status == 422) {
              myThis.errorsList = error.response.data.errors;
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
    },

    RedirectTable() {
      this.$router.push('/TableEnseignants');
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
  max-width: 500px; /* Adjust the value as needed */
  width: 90%;
}
</style>
