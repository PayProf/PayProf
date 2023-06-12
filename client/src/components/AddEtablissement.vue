<template>
  <button class="btn btn-primary rounded mb-4" @click="showPopup = true">ADD</button>
  <div v-if="showPopup" class="popup">
    <div class="popup-content card w-96 bg-neutral ">
      <div class="card-body items-center text-center">
        <h2 class="card-title">Add Etablissement</h2>
        <form @submit.prevent="saveEtablissement(); showPopup = false">
          <!-- Form fields fogr addin an Etablissement -->
          <div class="grid grid-cols-2 gap-4">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Nom</span>
              </label>
              <input type="text" v-model="model.Etablissement.nom" placeholder="Nom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Code</span>
              </label>
              <input type="text" v-model="model.Etablissement.code" placeholder="Code" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Ville</span>
              </label>
              <input type="text" v-model="model.Etablissement.ville" placeholder="Ville" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Telephone</span>
              </label>
              <input type="text" v-model="model.Etablissement.Telephone" placeholder="Telephone"
                class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Fax</span>
              </label>
              <input type="text" v-model="model.Etablissement.FAX" placeholder="Année universitaire"
                class="input input-bordered" />
            </div>
          </div>

          <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary rounded" style="margin-bottom: 5px;">
              Add Etablissement
            </button>
            <button type="button" class="btn btn-primary rounded" @click="showPopup = false">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
  
<script>
import axios from 'axios';
export default {
  name: 'AddEtablissement',
  data() {
    return {
      errorsList: "",
      showPopup: false,
      model: {
        Etablissement: {
          nom: "",
          code: "",
          ville: "",
          Telephone: "",
          FAX: ""
        }
      }
    }
  },

  methods: {
    saveEtablissement() {
      const token = store.state.user.token;
      const config = {
        headers: { Authorization: `Bearer ${token}` }
      };
      var myThis = this;
      axios.post('http://127.0.0.1:8000/api/etablissements', this.model.Etablissement, config)
        .then(result => {
          console.log(result.data)
          this.model.Etablissement = {
            nom: "",
            code: "",
            ville: "",
            Telephone: "",
            FAX: ""

          }

        }).catch(function (error) {

          if (error.response) {

            if (error.response.status == 422) {

              //if you don't specify "myThis" an undefined error will be shown
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