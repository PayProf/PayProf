<template>
  <div>
    <div class="flex justify-center mt-5 ">
      <button class="btn btn-primary rounded mb-4 px-20" @click="showPopup = true">Changer le Mot de Passe</button>
    </div>

    <div v-if="showPopup" class="popup z-40">
      <div class="popup-content card w-96 bg-neutral ">
        <div class="card-body items-center text-center">
          <h2 class="card-title">Changer Votre Mot de Passe</h2>
          <form @submit.prevent="UpdatePassword(); showPopup = false">
            <!-- Form fields fogr addin an Directeur -->
            <div class="grid grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Mot De Passe</span>
                </label>
                <input type="text" required="true" v-model="NewPassword.password" placeholder="Ancien" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Nouveau Mot De Passe</span>
                </label>
                <input type="text" required="true" v-model="NewPassword.new_password" placeholder="Nouveau"
                       class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Confirmation</span>
                </label>
                <input type="text" required="true" v-model="NewPassword.new_password_confirmation" placeholder="Confirmer" class="input input-bordered" />
              </div>

            </div>

            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary rounded" style="margin-bottom: 5px;">
                Changer
              </button>
              <button type="button" class="btn btn-error rounded" @click="showPopup = false">
                Annuler
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
import { useToast } from "vue-toastification";
export default {
  name: "UpdatePassword",
  data() {
    return {
      errorsList: "",
      showPopup:false,
      NewPassword:{
        password: "",
        new_password: "",
        new_password_confirmation: ""
      },
    }
  },
  methods:{
    async UpdatePassword(){
      try{
      const token = store.state.user.token;
      const config = {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json'
        }
      };
        console.log(this.NewPassword)
      const response = await axios.put('http://127.0.0.1:8000/api/profil/'+store.state.user.id+'/update',this.NewPassword,config);
      console.log(response)
    }
    catch (error){
        console.log(error)
        const toast = useToast();
        toast.error(error.response.data.message,{
          timeout:3000,
        });
    }
    }
  }
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