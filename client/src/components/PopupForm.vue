<template>
  <div>
    <!-- <button @click="showPopup">Add</button> -->
    <div v-if="isPopupVisible" class="popup">
      <div class="popup-content">
        <form @submit.prevent="addEnseignant">
          <!-- Form fields for adding an enseignant -->
          <input type="text" v-model="ppr" placeholder="PPR" />
          <input type="text" v-model="nom" placeholder="Nom" />
          <input type="text" v-model="prenom" placeholder="Prénom" />
          <input type="email" v-model="email" placeholder="Email" />

          <button type="submit">Add Enseignant</button>
        </form>
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
  closeForm() {
      this.$emit('close');
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
