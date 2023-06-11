<template style="margin-top: 100px;">
<div class="p-4 mt-20 sm:mx-30">
        <div class="p-4 border-2 border-gray-200  rounded-lg ">
            <div class="flex items-center justify-center h-60 mb-6 mt-10 rounded bg-gray-50 ">
                <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                    <figure><img src=""  /></figure>
                    <div class="card-body">
                        <h2 class="card-title">Profile</h2>
                        <p>If a dog chews shoes whose shoes does he choose?</p>
                        <div class="card-actions justify-end">
                            
                            <button class="btn btn-primary" @click="showProfile">Consulter</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6 mb-4 pt-6">
                <div class="flex items-center justify-center rounded bg-gray-50 h-40 ">
                    <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                        <figure><img src=""  /></figure>
                        <div class="card-body">
                            <h2 class="card-title">Table des enseignants</h2>
                            <p>If a dog chews shoes whose shoes does he choose?</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-primary" @click="showEns">Consulter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center rounded bg-gray-50 h-40 ">
                    <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                        <figure><img src=""  /></figure>
                        <div class="card-body">
                            <h2 class="card-title">tables des interventions</h2>
                            <p>If a dog chews shoes whose shoes does he choose?</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-primary" @click="ShowAllint">Consulter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="OpenProfile" class="card card-side bg-base-100 shadow-xl">
            <div class="card-body">
              <h1 class="text-2xl font-bold">Profile enseignat : {{ user.nom }} {{ user.prenom }}</h1>
                    <p class="py-2"><strong>Nom:</strong> {{user.nom}}</p>
                    <p class="py-2"><strong>Prenom :</strong> {{user.prenom}}</p>
                    <p class="py-2"><strong>Email :</strong> johndoe@example.com</p>
                    <p class="py-2"><strong>Etablissment :</strong> Ecole Nationale des sciences appliquee</p>
                    <h2 class="card-title">New movie is released!</h2>
              <p>Click the button to watch on Jetflix app.</p>
              <div class="card-actions justify-end">
                <button class="btn btn-primary">Change Password</button>
              </div>
          </div>
        </div>

      <TableEnseignant v-if="OpenEns"/>
      <ValidateIntervention v-if="OpenInt"/>

  </div>
</template>

  

<script>
import TableEnseignant from '../TablesEtab/TableEnseignant.vue';
import TableDirecteurs from '../TablesUAE/TableDirecteurs.vue';
import ValidateIntervention from '../TablesEtab/ValidateIntervention.vue';
import PopupForm from '../../components/AddEnseignant.vue';
import TableEnseignats from '../../views/TablesEtab/TableEnseignant.vue'
import {mapActions,mapState} from 'vuex';
import Router from "../../router/index.js";
export default {
  name: 'Admin',
  components: {
    TableEnseignant,
    PopupForm,

    TableDirecteurs,
    ValidateIntervention,

  },
  data() {
    return {
      showPopupForm: false,
      OpenEns:false,
      OpenProfile:false,
      OpenInt:false,

    };
  },
  methods: {
  //   ...mapActions([
  //     'getEnseignants'
  // ]),
  showStats() {
      this.OpenStats = !this.OpenStats;
    },
    showEnseignatsA() {
      this.OpenEnseignants = !this.OpenEnseignants;
    },
    showInterventionsA() {
      this.OpenInterventions = !this.OpenInterventions;
    },
    showEns(){
      this.OpenEns = !this.OpenEns;
    },
    showProfile(){
      this.OpenProfile = !this.OpenProfile;
    },
    ShowAllint(){
      this.OpenInt = !this.OpenInt;
    }
  },
  computed:{
    ...mapState([
        'enseignants',
        'user'
    ])

  },
  // async created(){
  //   await this.$store.dispatch('getEnseignants');
  // }
};


</script>

