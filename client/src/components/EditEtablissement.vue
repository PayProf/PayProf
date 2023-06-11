<template>

    <div class="popup">
      <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
        <div class="card-body">
          <form>
            <!-- Form fields for adding an enseignant -->
            <div class="form-control">
              <label class="label">
                <span class="label-text">Nom</span>
              </label>
              <input type="text" v-model="model.Etablissement.Nom" placeholder="PPR" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">ville</span>
              </label>
              <input type="text" v-model="model.Etablissement.ville" placeholder="Nom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Telephone</span>
              </label>
              <input type="number" v-model="model.Etablissement.Telephone" placeholder="Prénom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">code</span>
              </label>
              <input type="number" v-model="model.Etablissement.code" placeholder="Email" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Nombre des enseignants</span>
              </label>
              <input type="number" v-model="model.Etablissement.Nombre_des_enseignants" placeholder="Email"
                class="input input-bordered" />
            </div>
            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary" style="border-radius: 10px;" @click="updateEtablissement()">Save</button>
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
  name: 'EditEtablissement',
  data() {
    return {
      EtablissementId:"",
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
  mounted() {
    this.EtablissementId = this.$route.params.id;
    this.getEtablissementData(this.$route.params.id);
  },

  methods: {
    getEtablissementData(EtablissementId) {
      axios.get(`http://localhost:8000/api/etablissement/${EtablisssementId}`).then(result => {
        this.model.Etablissement = result.data.Etablissement
      })

    },
    async updateEtablissement() {
      var myThis = this;
      await axios.put(`http://localhost:8000/api/etablissement/${this.EtablissementId}`, this.model.Etablissement)
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