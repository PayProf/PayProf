<template>
  <div class="ml-30 my-20">
    <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100 justify-center">
      <div class="card-body">
        <form>
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
              <span class="label-text">Etablissement</span>
            </label>
            <input type="text" v-model="model.Enseignant.NomEtab" placeholder="Etablissement"
              class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Date Naissance</span>
            </label>
            <input type="date" v-model="model.Enseignant.DateNaissance" placeholder="Etablissement"
              class="input input-bordered" />
          </div>

          <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary" style="border-radius: 10px;"
              @click="saveEnseignant(), RedirectTable()">Add
              Enseignant</button>
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
  name: 'AddEnseignant',
  data() {
    return {
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