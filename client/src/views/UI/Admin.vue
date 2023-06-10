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
      <TableEnseignant v-if="OpenEns"/>
      <ValidateIntervention v-if="OpenInt"/>
    </div>
  </template>
  

<script>
import TableEnseignant from '../TablesEtab/TableEnseignant.vue';
import TableDirecteurs from '../TablesUAE/TableDirecteurs.vue';
import ValidateIntervention from '../TablesEtab/ValidateIntervention.vue';
import PopupForm from '../../components/AddEnseignant.vue';
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
    ...mapActions([
      'getEnseignants'
  ]),
    showPopup() {
      this.showPopupForm = true;
    },
    showEns(){
      this.OpenEns = !this.OpenEns;
    },
    showProfile(){
      this.OpenDir = !this.OpenDir;
    },
    ShowAllint(){
      this.OpenInt = !this.OpenInt;
    }
  },
  computed:{
    ...mapState([
        'enseignants',
    ])
  },
  async created(){
    await this.$store.dispatch('getEnseignants');
  }
};


</script>

