<template>
  <div>
    <div class="flex justify-center mt-5 ">
      <button class="btn btn-primary rounded mb-4 px-20" @click="showPopup = true"><i class="fa-solid fa-plus"></i></button>
    </div>
    
    <div v-if="showPopup" class="popup z-40">
      <div class="popup-content card w-96 bg-neutral ">
        <div class="card-body items-center text-center">
          <h2 class="card-title">Add Directeur</h2>
          <form @submit.prevent="saveDirecteur(); showPopup = false">
            <!-- Form fields fogr addin an Directeur -->
            <div class="grid grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text">PPR</span>
                </label>
                <input type="text" v-model="model.Directeur.PPR" placeholder="PPR" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Nom</span>
                </label>
                <input type="text" v-model="model.Directeur.nom" placeholder="Nom"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Prenom</span>
                </label>
                <input type="text" v-model="model.Directeur.prenom" placeholder="Prenom" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Etablissement</span>
                </label>
                <input type="text" v-model="model.Directeur.etablissement_id" placeholder="Email"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Email</span>
                </label>
                <input type="text" v-model="model.Directeur.email_perso" placeholder="Email"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Date Naissance</span>
                </label>
                <input type="date" v-model="model.Directeur.DateNaissance" placeholder="DateNaissance"
                  class="input input-bordered" />
              </div>
              
            </div>

            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary rounded" style="margin-bottom: 5px;">
                Add Directeur
              </button>
              <button type="button" class="btn btn-error rounded" @click="showPopup = false">
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
import store from '../store';
import axios from 'axios';
export default {
  name: 'AddDirecteur',

  data() {
    return {
      errorsList: "",
      showPopup:false,
      model: {
        Directeur: {
          PPR: "",
          nom: "",
          prenom: "",
          Email: "",
          NomEtab: "",
          DateNaissance: ""
        }
      }
    }
  },

  methods: {
    saveDirecteur() {
      const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };

      var myThis = this;
      axios.post('http://127.0.0.1:8000/api/Directeur', this.model.Directeur,config)
        .then(result => {
          console.log(result.data)
          this.model.Directeur = {
            PPR: "",
            nom: "",
            prenom: "",
            Email: "",
            etablissement_id: "",
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
      this.$router.push('/TableDirecteurs')
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