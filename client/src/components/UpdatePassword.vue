<template>
  <div>
    <div class="flex justify-center mt-5 ">
      <button class="btn btn-primary rounded mb-4 px-20" @click="showPopup = true">Changer le Mot de Passe</button>
    </div>

    <div v-if="showPopup" class="popup z-40">
      <div class="popup-content card w-96 bg-neutral ">
        <div class="card-body items-center text-center">
          <h2 class="card-title">Changer Votre Mot de Passe</h2>
          <form @submit.prevent="saveDirecteur(); showPopup = false">
            <!-- Form fields fogr addin an Directeur -->
            <div class="grid grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Ancien Mot De Passe</span>
                </label>
                <input type="text" v-model="NewPassword.OldPass" placeholder="PPR" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Nouveau Mot De Passe</span>
                </label>
                <input type="text" required="true" v-model="NewPassword.NewPass" placeholder="Nom"
                       class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Confirmation du Nouveau Mot De Passe</span>
                </label>
                <input type="text" required="true" v-model="NewPassword.NewPassConf" placeholder="Prenom" class="input input-bordered" />
              </div>

            </div>

            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary rounded" style="margin-bottom: 5px;">
                Add Directeur
              </button>
              <button type="button" class="btn btn-error rounded" @click="showPopup = false">
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
  name: "UpdatePassword",
  data() {
    return {
      errorsList: "",
      showPopup:false,
      NewPassword:{
        OldPass:'',
        NewPass:'',
        NewPassConf:'',
      },
    }
  },
}

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