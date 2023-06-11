<template>
  <div>
    <button class="btn btn-primary rounded mb-4" @click="showPopup">ADD</button>
    <div v-if="isPopupVisible" class="popup">
      <div class="popup-content card w-96 bg-neutral text-neutral-content">
        <div class="card-body items-center text-center">
          <h2 class="card-title">Add Intervention</h2>
          <form @submit.prevent="saveIntervention();">
            <!-- Form fields for adding an intervention -->
            <div class="grid grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text">PPR</span>
                </label>
                <input type="text" v-model="model.Enseignant.Code" placeholder="PPR" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Nom</span>
                </label>
                <input type="text" v-model="model.Enseignant.Nom" placeholder="Nom" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Prénom</span>
                </label>
                <input type="text" v-model="model.Enseignant.Prenom" placeholder="Prénom" class="input input-bordered" />
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
                <input type="text" v-model="model.Enseignant.Grade" placeholder="Grade" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Date de naissance</span>
                </label>
                <input type="date" v-model="model.Enseignant.DateNaissance" class="input input-bordered" />
              </div>
            </div>
            <div class="form-control mt-6">
              <button @click="ADDEnse" class="btn btn-primary rounded" style="margin-bottom: 5px;">
                Add Enseignant
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
  
<script>
import axios from 'axios';
export default {
  name: 'AddEnseignant',
  data() {
    return {
      isPopupVisible: false,
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
      this.$router.push('/TableEnseignants')
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
}
</style>