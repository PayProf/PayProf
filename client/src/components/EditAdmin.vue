<template>

    <div class="popup">
      <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
        <div class="card-body">
          <form>
            <!-- Form fields for adding an enseignant -->
            <div class="form-control">
              <label class="label">
                <span class="label-text">PPR</span>
              </label>
              <input type="text" v-model="model.Admins.PPR" placeholder="PPR" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Nom</span>
              </label>
              <input type="text" v-model="model.Admins.nom" placeholder="Nom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Prénom</span>
              </label>
              <input type="text" v-model="model.Admins.prenom" placeholder="Prénom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <input type="email" v-model="model.Admins.email_perso" placeholder="Email" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Etablissement</span>
              </label>
              <input type="number" v-model="model.Admins.etablissement_id" placeholder="Email"
                class="input input-bordered" />
            </div>
            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary" style="border-radius: 10px;" @click="updateAdmin()">Save</button>
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
  name: 'EditAdmin',
  data() {
    return {
      AdminId:"",
      model: {
        Admins: {
          PPR: "",
          email_perso: "",
          etablissement_id: "",
          id: "",
          nom: "",
          prenom: ""
        }
      }
    }
  },
  mounted() {
    this.AdminId = this.$route.params.id;
    this.getAdminData(this.$route.params.id);
  },

  methods: {
    getAdminData(AdminId) {
      axios.get(`http://localhost:8000/api/admins/${AdminId}`).then(result => {
        this.model.Admins = result.data.Admins
      })

    },
    async updateAdmin() {
      var myThis = this;
      await axios.put(`http://localhost:8000/api/admins/${this.AdminId}`, this.model.Admins)
        .then(result => {
          console.log(result.data);
        })
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