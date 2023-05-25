<template>
  <div>
    <button @click="showPopup" class="btn btn-primary"
      style="float: right; margin-right: 30px; margin-bottom: 30px; border-radius: 10px;">Add</button>

    <div v-if="isPopupVisible" class="popup">
      <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
        <div class="card-body">
          <form @submit.prevent="addAdmins">
            <!-- Form fields for adding an enseignant -->
            <div class="form-control">
              <label class="label">
                <span class="label-text">PPR</span>
              </label>
              <!--------------------- PPR input ------------------------>

              <input type="text" v-model="ppr" placeholder="PPR" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Nom</span>
              </label>
              <!----------------------- NAME input ----------------------->
              <input type="text" v-model="nom" placeholder="Nom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Prénom</span>
              </label>
              <!----------------------- Prenom input ----------------------->
              <input type="text" v-model="prenom" placeholder="Prénom" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <!----------------------- Email Input ----------------------->
              <input type="email" v-model="email" placeholder="Email" class="input input-bordered" />
            </div>

            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Add admin</button>
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
  name: "AjouterAdmins",
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
    close() {
      this.isPopupVisible = false;
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
  