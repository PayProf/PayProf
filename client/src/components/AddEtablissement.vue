<template>
  <div class="ml-30 my-20">
    <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100 justify-center">
      <div class="card-body">
        <form>
          <!-- Form fields for adding an enseignant -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Nom</span>
            </label>
            <input type="text" v-model="model.Etablissement.Nom" placeholder="Nom" class="input input-bordered" />
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
            <input type="number" v-model="model.Etablissement.Telephone" placeholder="telephone"
              class="input input-bordered" />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">Fax</span>
            </label>
            <input type="number" v-model="model.Etablissement.code" placeholder="Fax" class="input input-bordered" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Nbr Enseingant</span>
            </label>
            <input type="number" v-model="model.Etablissement.Nombre_des_enseignants" placeholder="NbrEnseingant"
              class="input input-bordered" />
          </div>

          <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary" style="border-radius: 10px;"
              @click="saveEtablissement(), RedirectTable()">Add
              Etablissement</button>
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
  name: 'AddEtablissement',
  data() {
    return {
      errorsList: "",
      model: {
        Etablissement: {
          code: "",
          ville: "",
          Telephone: "",
          Nom: "",
          Nombre_des_enseignants: ""
        }
      }
    }
  },

  methods: {
    saveEtablissement() {

      var myThis = this;
      axios.post('http://127.0.0.1:8000/api/etablissements', this.model.Etablissement)
        .then(result => {
          console.log(result.data)
          this.model.Etablissement = {
            code: "",
            ville: "",
            Telephone: "",
            Nom: "",
            Nombre_des_enseignants: ""
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

    //Redirect to table view
    RedirectTable() {
      this.$router.push('/TableEtablissements')
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