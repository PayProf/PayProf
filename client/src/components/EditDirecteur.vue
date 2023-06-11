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
              <input type="text" v-model="model.Directeurs.PPR" placeholder="PPR" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Nom</span>
              </label>
              <input type="text" v-model="model.Directeurs.nom" placeholder="Nom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Prénom</span>
              </label>
              <input type="text" v-model="model.Directeurs.prenom" placeholder="Prénom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <input type="email" v-model="model.Directeurs.email_perso" placeholder="Email" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Etablissement</span>
              </label>
              <input type="number" v-model="model.Directeurs.etablissement_id" placeholder="Email"
                class="input input-bordered" />
            </div>
            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary" style="border-radius: 10px;" @click="updateDirecteur()">Save</button>
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
  name: 'EditDirecteur',
  data() {
    return {
      DirecteurId:"",
      model: {
        Directeurs: {
          PPR: "",
          nom: "",
          prenom: "",
          NomEtab: "",
          Email: "",
          DateNaissance: ""
        }
      }
    }
  },
  mounted() {
    this.DirecteurId = this.$route.params.id;
    this.getDirecteurData(this.$route.params.id);
  },

  methods: {
    getDirecteurData(DirecteurId) {
      axios.get(`http://localhost:8000/api/Directeurs/${DirecteurId}`).then(result => {
        this.model.Directeurs = result.data.Directeurs
      })

    },
    async updateDirecteur() {
      var myThis = this;
      await axios.put(`http://localhost:8000/api/Directeurs/${this.DirecteurId}`, this.model.Directeurs)
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