<template>
  <div>
    <div class="flex justify-center mt-5 ">
      <button class="btn btn-primary rounded mb-4 px-20" @click="showPopup = true"><i class="fa-solid fa-plus"></i></button>
    </div>
    <div v-if="showPopup" class="popup z-40">
      <div class="popup-content card w-96 bg-neutral ">
        <div class="card-body items-center text-center">
          <h2 class="card-title">Add Admin</h2>
          <form @submit.prevent="saveAdmin(); showPopup = false">
            <!-- Form fields fogr addin an Admin -->
            <div class="grid grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text">PPR</span>
                </label>
                <input type="text" v-model="model.Admin.PPR" placeholder="PPR" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Nom</span>
                </label>
                <input type="text" v-model="model.Admin.nom" placeholder="Nom" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Prenom</span>
                </label>
                <input type="text" v-model="model.Admin.prenom" placeholder="Prenom" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Etablissement</span>
                </label>
                <select v-model="model.Admin.etablissement_id" class="select select-bordered h-9">

                  <option value="">Select etablissement</option>
                  <option v-for="(Etablissement, id) in this.Etablissements.data" :key="id">
                    {{ Etablissement.id }}
                  </option>

                </select>
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Email</span>
                </label>
                <input type="text" v-model="model.Admin.email_perso" placeholder="Email" class="input input-bordered" />
              </div>

            </div>

            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary rounded" style="margin-bottom: 5px;">
                Add Admin
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
import store from '../store';
import axios from 'axios';
export default {
  name: 'AddAdmin',
  data() {
    return {
      errorsList: "",
      Etablissements:[],
      showPopup: false,
      model: {
        Admin: {
          PPR: "",
          nom: "",
          prenom: "",
          email_perso: "",
          etablissement_id: ""
        }
      }
    }
  },
  mounted(){
    this.getEtablissements();
  },
  methods: {
    async getEtablissements() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('http://127.0.0.1:8000/api/etablissements',config).then(result=>{
          console.log('test axios')
          this.Etablissements = result.data
        })
        console.log(this.Etablissements)
      }
      catch (error) {
        console.log(error)
      }
    },
    saveAdmin() {
      const token = store.state.user.token;
      const config = {
        headers: { Authorization: `Bearer ${token}` }
      };
      var myThis = this;
      axios.post('http://127.0.0.1:8000/api/admins', this.model.Admin, config)
        .then(result => {
          console.log(result.data)
          this.model.Admin = {
            PPR: "",
            nom: "",
            prenom: "",
            email_perso: "",
            etablissement_id: ""
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
      this.$router.push('/TableAdmins')
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