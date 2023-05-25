<template>
  <div>
    <button @click="showPopup" class="btn btn-primary" style="float: right; margin-right: 30px; margin-bottom: 30px; border-radius: 10px;">Add</button>
    <div v-if="isPopupVisible" class="popup">
      <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
        <div class="card-body">
          <form @submit.prevent="addEtablissement" href="formName">
            <!-- Form fields for adding an enseignant -->
            <div class="form-control">
              <label class="label">
                <span class="label-text">Nom</span>
              </label>
              <input type="text" v-model="nom" placeholder="Nom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Telephone</span>
              </label>
              <input type="number" v-model="telephone" placeholder="Télephone" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Fax</span>
              </label>
              <input type="number" v-model="fax" placeholder="Fax" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Ville</span>
              </label>
              <input type="text" v-model="ville" placeholder="Ville" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Nombre enseignants</span>
              </label>
              <input type="number" v-model="nbrEnseignant" placeholder="Nombre enseignants" class="input input-bordered" />
            </div>

            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary p-4" style="border-radius: 10px;" @click="showPopup">Add
                etablissement</button>
              <button @click="close" class="btn btn-primary" style="border-radius: 10px;">Cancel</button>

            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isPopupVisible: false,
      model: {
        nom: '',
        prenom: '',
        telephone: '',
        fax: '',
        ville: '',
        nbrEnseignant: '',
      },
      rules: {

      },

    };
  },
  methods: {
    showPopup() {
      this.isPopupVisible = true;
    },
    close() {
      this.isPopupVisible = false;
    },
    savefrom(formName){
      this.$refs[formName].validate((valid)=>{
        if(valid){
          this.$store.dispatch('addEtablissement',this.model)

        }
      })
    },
    addEtablissement() {
      const etablissement = {
        ppr: this.ppr,
        nom: this.nom,
        prenom: this.prenom,
        email: this.email,
      };

      // Dispatch the action to add the enseignant
      this.$store.dispatch('addEtablissement', etablissement);

      // Reset form fields
      this.ppr = '';
      this.nom = '';
      this.prenom = '';
      this.email = '';

      // Hide the popup
      this.isPopupVisible = false;
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