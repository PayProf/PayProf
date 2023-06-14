<template>
  <div class="overflow-x-auto">
   <table class="table table-zebra w-full">
           <!-- head -->
           <thead>
             <tr>
               <th class="z-30">PPR</th>
               <th>Etablissement</th>
               <th>Intitule Intervention</th>
               <th>Année universitaire</th>
               <th>Semestre</th>
               <th>Date début</th>
               <th>Date fin</th>
               <th>Nombre Heures</th>
               <th>Visa UAE</th>
               <th>Visa Etab</th>
               <th v-if="role == 3">Actions</th>
             </tr>
           </thead>
           <tbody>
             <tr v-for="(Intervention,index) in Interventions" :key="index">
               <td>{{ Intervention.enseignant.PPR }}</td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.etablissement.nom}}</div><div v-else><input type="text" :placeholder="Intervention.etablissement.nom" v-model="UpdatedIntervetion.NomEtab" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.intitule_intervention}}</div><div v-else><input type="text" :placeholder="Intervention.intitule_intervention" v-model="UpdatedIntervetion.intitule_intervention" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.annee_univ }}</div><div v-else><input type="text" :placeholder="Intervention.annee_univ" v-model="UpdatedIntervetion.annee_univ" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.semestre }}</div><div v-else><input type="text" :placeholder="Intervention.semestre" v-model="UpdatedIntervetion.semestre" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.date_debut }}</div><div v-else><input type="text" :placeholder="Intervention.date_debut" v-model="UpdatedIntervetion.date_debut" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.date_fin }}</div><div v-else><input type="text" :placeholder="Intervention.date_fin" v-model="UpdatedIntervetion.date_fin" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.Nbr_heures }}</div><div v-else><input type="text" :placeholder="Intervention.Nbr_heures" v-model="UpdatedIntervetion.Nbr_heures" class="input input-ghost w-full max-w-xs" /></div></td>
               <td>
                 <input type="checkbox" :checked="Intervention.visa_uae" class="checkbox" v-if="role == 3 && !Interventions.visa_etab" @change="UpVisaUAE(Intervention.id,index)"/>
                 <div v-else class="flex justify-center">
                 <i class="fa-solid fa-x text-red-500" v-if="!Intervention.visa_uae"></i>
                 <i class="fa-solid fa-check text-green-500" v-else></i>
                 </div>
               </td>
               <td>
                 <input type="checkbox" :checked="Intervention.visa_etab" class="checkbox" v-if="role == 1" />
                 <div v-else class="flex justify-center">
                   <i class="fa-solid fa-x text-red-500" v-if="!Intervention.visa_etab"></i>
                   <i class="fa-solid fa-check text-green-500" v-else></i>
                 </div>
               </td>
               <td v-if="this.role==2">
                 <button class="add-btn px-4" v-if="!Intervention.visa_uae" >
                   <i class="fas fa-pen" v-if="!IsRow(Intervention.id)" @click="ToggleEdit(Intervention.id)"></i>
                   <i class="fas fa-check" v-else @click="ConfirmEdit(Intervention.id)"></i>
                   <span class="tooltip" data-tooltip="inspect">modifier</span>
                 </button>

                 <button class="add-btn px-4" @click="deleteIntervention(Intervention.id)" v-if="!Intervention.visa_uae" >
                   <i class="fas fa-trash" ></i>
                   <span class="tooltip" data-tooltip="inspect">supprimer</span>
                 </button>
                 <!-- This page isn't created yet !!!! -->
               </td>
             </tr>
           </tbody>
         </table>
  </div>
          <div class="flex justify-center items-center p-5">
            <v-pagination
                v-model="page"
                :pages="pagecount"
                :range-size="1"
                active-color="#1d774d"
                @update:modelValue="getInterventions"
            />
          </div>
    <div class="flex justify-center items-center">
           <AddIntervention @intervention-added="getInterventions" v-if="role == 2"/>
    </div>


</template>

<script>
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import axios from "axios";
import store from "../../store.js";
import AddIntervention from "../../components/AddIntervention.vue";
export default {
 name: 'Interventions',
 components:{
   AddIntervention,
   VPagination,
 },
 data() {
   return {
     Interventions: [],
     UpdatedIntervetion:{
     },
     role:store.state.user.role,
     page:1,
     pagecount:null,
     EditMode:false,
     EditedId:null,
   }
 },

 async mounted() {

   await this.getInterventions();

 },
 methods: {
   async UpVisaUAE(id,index){
     try {
       const token = store.state.user.token;
       const config = {
         headers: {
           Authorization: `Bearer ${token}`,
           Accept: 'application/json',
         }
       };
       this.UpdatedIntervetion.visa_uae=!this.Interventions[index].visa_uae;

       await axios.patch(
           'http://127.0.0.1:8000/api/Intervention/'+id+'/visauae',
           {VisaEtab:this.UpdatedIntervetion.visa_uae}, // Pass the object in the request payload
           config
       );
       await this.getInterventions();
     } catch (error) {
       console.log(error);
     }
   },
   async ConfirmEdit(id) {
     try {
       const token = store.state.user.token;
       const config = {
         headers: {
           Authorization: `Bearer ${token}`,
           Accept: 'application/json',
         }
       };

       await axios.patch(
           `http://127.0.0.1:8000/api/Intervention/${id}`,
           this.UpdatedIntervetion, // Pass the object in the request payload
           config
       );
       this.DeEdit();
       await this.getInterventions();
     } catch (error) {
       console.log(error);
     }
   },

   ToggleEdit(id){
     this.EditedId=id;
   },
   DeEdit(){
     this.EditedId=null;
   },
   IsRow(id){
     return id === this.EditedId;
   },
   async deleteIntervention(id){
     try {
       const token = store.state.user.token;
       const config = {
         headers: { Authorization: `Bearer ${token}` }
       };
       const response = await axios.delete('http://127.0.0.1:8000/api/Intervention/'+id,config);
       await this.getInterventions();
     }
     catch (error) {
       console.log(error)
     }
   },
   async getInterventions() {
     try {
       const token = store.state.user.token;
       const config = {
         headers: { Authorization: `Bearer ${token}` }
       };
       const response = await axios.get('http://127.0.0.1:8000/api/Intervention/int/ShowMyEtabInterventions?page='+this.page,config)
       this.Interventions=response.data.data
       this.pagecount=response.data.last_page
     }
     catch (error) {
       console.log(error)
     }
   }
 },

}
</script>

<style>

</style>