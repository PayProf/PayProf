<template>
  <div>
    <button @click="showPopup" class="btn btn-primary" style="float: right; margin-right: 30px; margin-bottom: 30px; border-radius: 10px;">Add</button>

    <div v-if="isPopupVisible" class="popup">
      <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
  <div class="card-body">
    <form @submit.prevent="addEnseignant">
      <!-- Form fields for adding an enseignant -->
      <div class="form-control">
        <label class="label">
          <span class="label-text">PPR</span>
        </label>
        <input type="text" v-model="ppr" placeholder="PPR" class="input input-bordered" />
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Nom</span>
        </label>
        <input type="text" v-model="nom" placeholder="Nom" class="input input-bordered" />
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Prénom</span>
        </label>
        <input type="text" v-model="prenom" placeholder="Prénom" class="input input-bordered" />
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Email</span>
        </label>
        <input type="email" v-model="email" placeholder="Email" class="input input-bordered" />
      </div>
      
      <div class="form-control mt-6">
        <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Add Enseignant</button>
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
      ppr: '',
      nom: '',
      prenom: '',
      email: '',
    };
  },
  methods: {
    showPopup() {
      this.isPopupVisible = true;
    },
    close(){
      this.isPopupVisible = false;
    },
    addEnseignant() {
      const enseignant = {
        ppr: this.ppr,
        nom: this.nom,
        prenom: this.prenom,
        email: this.email,
      };

      // Dispatch the action to add the enseignant
      this.$store.dispatch('addEnseignant', enseignant);

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