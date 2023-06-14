<template>

  <div class="z-40">
    <button class="btn btn-primary rounded mb-4 px-20" @click="showPopup = true"><i class="fa-solid fa-plus"></i></button>
    <div v-if="showPopup" class="popup">
      <div class="popup-content rounded-lg">
        <div class="flex justify-center">
        <h2 class="card-title">Add Enseignant</h2>
        </div>
        <form @submit.prevent="saveEnseignant(); showPopup = false">
          <!-- Form fields for adding an enseignant -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">PPR</span>
            </label>
            <input type="number" v-model="model.Enseignant.PPR" placeholder="PPR" class="input input-bordered h-9" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Nom</span>
            </label>
            <input type="text" v-model="model.Enseignant.nom" placeholder="Nom" class="input input-bordered h-9" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Prénom</span>
            </label>
            <input type="text" v-model="model.Enseignant.prenom" placeholder="Prénom" class="input input-bordered h-9" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Email</span>
            </label>
            <input type="email" v-model="model.Enseignant.email_perso" placeholder="Email" class="input input-bordered h-9" />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Grade</span>
            </label>
            <select v-model="model.Enseignant.Grade" class="select select-bordered h-9">
              <option value="">Select Grade</option>
              <option value="PA">PA</option>
              <option value="PE">PS</option>
              <option value="PES">PES</option>
            </select>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Date Naissance</span>
            </label>
            <input type="date" v-model="model.Enseignant.DateNaissance" placeholder="Date Naissance" class="input input-bordered h-9" />
          </div>

          <div class="form-control mt-6 grid grid-cols-2 flex items-center">
            <button type="submit" class="btn btn-primary h-9" style="border-radius: 10px;" @click="saveEnseignant()">Add Enseignant</button>
            <button class="btn btn-error text-white h-9 ml-2" style="border-radius: 10px;" @click="showPopup = false">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import store from '../store'

export default {
  name: 'AddEnseignant',
  data() {
    return {
      showPopup: false,
      model: {
        Enseignant: {
          PPR:'',
          nom:'',
          prenom:'',
          DateNaissance:'',
          email_perso:'',
          Grade:'',
        }
      }
    }
  },

  methods: {
    async saveEnseignant() {
      // Call the API to save the enseignant
      await this.postEnseignant();

      // Additional logic after saving the enseignant
      this.showPopup = false;
    },
    
    async postEnseignant() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json'
          }
        };
        const response = await axios.post(`http://127.0.0.1:8000/api/Enseignant`, this.model.Enseignant, config);
        console.log('Enseignant added successfully');
        this.$emit('Enseignant-added');

      } catch (error) {
        console.log(error);
      }
    },

    RedirectTable() {
      this.$router.push('/TableEnseignants');
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
  max-width: 500px; /* Adjust the value as needed */
  width: 90%;
}
</style>
