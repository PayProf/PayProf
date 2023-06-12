<template>
  <div>
    <button class="btn btn-primary rounded mb-4 px-20" @click="showPopup = true"><i class="fa-solid fa-plus"></i></button>
    <div v-if="showPopup" class="popup z-50">
      <div class="popup-content card w-96 bg-neutral ">
        <div class="card-body items-center text-center">
          <h2 class="card-title">Add Intervention</h2>
          <form @submit.prevent="saveIntervention(); showPopup = false">
            <!-- Form fields fogr addin an intervention -->
            <div class="grid grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text">PPR</span>
                </label>
                <input type="text" v-model="model.Intervention.PPR" placeholder="Code" class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Etablissement</span>
                </label>
                <input type="text" v-model="model.Intervention.NomEtab" placeholder="Etablissement"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Intitule Intervention</span>
                </label>
                <input type="text" v-model="model.Intervention.IntituleIntervention" placeholder="Intitule"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Année universitaire</span>
                </label>
                <input type="text" v-model="model.Intervention.AnneeUniv" placeholder="Année universitaire"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Semestre</span>
                </label>
                <select v-model="model.Intervention.Semestre" class="select select-bordered">
                  <option value="S1">1st Semester</option>
                  <option value="S2">2nd Semester</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label">
                  <!-- l -->
                  <span class="label-text">Date début</span>
                </label>
                <input type="date" v-model="model.Intervention.DateDebut" placeholder="Date début"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Date fin</span>
                </label>
                <input type="date" v-model="model.Intervention.DateFin" placeholder="Date fin"
                  class="input input-bordered" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Nombre d'heure</span>
                </label>
                <input type="text" v-model="model.Intervention.NbrHeures" placeholder="Nombre d'heure"
                  class="input input-bordered" />
              </div>
            </div>

            <div class="form-control mt-6 grid grid-cols-2 flex items-center">
              <button type="submit" class="btn btn-primary h-9" style="border-radius: 10px;" @click="postIntervention">Add Intervention</button>
              <button class="btn btn-error text-white h-9 ml-2" style="border-radius: 10px;" @click="showPopup = false">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import store from "../store.js";
export default {
  name: 'AddIntervention',
  data() {
    return {
      showPopup: false,
      model: {
        Intervention: {
          IntituleIntervention: '',
          AnneeUniv: '',
          Semestre: '',
          DateDebut: '',
          DateFin: '',
          PPR: '',
          NomEtab:'',
          NbrHeures:'',
        }
      },
      role:store.state.user.role,
    };
  },
  methods: {
    async postIntervention() {
      try {
        const token = store.state.user.token;
        const config = {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json'
          }
        };
        await axios.post(`http://127.0.0.1:8000/api/Intervention`, this.model.Intervention, config);
        console.log('Enseignant added successfully');
        this.$emit('intervention-added');
        this.showPopup=false;
      } catch (error) {
        console.log(error);
      }
    },

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
