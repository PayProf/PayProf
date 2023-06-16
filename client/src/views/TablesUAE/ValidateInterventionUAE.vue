<template>
  <div class="overflow-x-auto">
    <h1 class="text-black font-bold text-xl">Table interventions :</h1>
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
               
             </tr>
           </thead>
           <tbody>
             <tr v-for="(Intervention,index) in Interventions" :key="index">
               <td>{{ Intervention.PPRProf }}</td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.NomEtab}}</div><div v-else><input type="text" :placeholder="Intervention.etablissement.nom" v-model="UpdatedIntervetion.NomEtab" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.IntituleIntervention}}</div><div v-else><input type="text" :placeholder="Intervention.intitule_intervention" v-model="UpdatedIntervetion.intitule_intervention" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.AnneeUniv }}</div><div v-else><input type="text" :placeholder="Intervention.annee_univ" v-model="UpdatedIntervetion.annee_univ" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.Semestre }}</div><div v-else><input type="text" :placeholder="Intervention.semestre" v-model="UpdatedIntervetion.semestre" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.DateDebut }}</div><div v-else><input type="date" :placeholder="Intervention.date_debut" v-model="UpdatedIntervetion.date_debut" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.DateFin }}</div><div v-else><input type="date" :placeholder="Intervention.date_fin" v-model="UpdatedIntervetion.date_fin" class="input input-ghost w-full max-w-xs" /></div></td>
               <td><div v-if="!IsRow(Intervention.id)">{{ Intervention.Nbrheures }}</div><div v-else><input type="number" :placeholder="Intervention.Nbr_heures" v-model="UpdatedIntervetion.Nbr_heures" class="input input-ghost w-full max-w-xs" /></div></td>
               <td>
                 <input type="checkbox" :checked="Intervention.VisaUae" :disabled="!Intervention.VisaEtab || Intervention.VisaUae " class="checkbox" v-if="role == 3 && !Interventions.VisaEtab" @change="UpVisaUAE(Intervention.id,index)"/>
                 <div v-else class="flex justify-center">
                 <i class="fa-solid fa-x text-red-500" v-if="!Intervention.VisaUae"></i>
                 <i class="fa-solid fa-check text-green-500" v-else></i>
                 </div>
               </td>
               <td>
                 <input type="checkbox" :checked="Intervention.VisaEtab " class="checkbox" v-if="role == 1" />
                 <div v-else class="flex justify-center">
                   <i class="fa-solid fa-x text-red-500" v-if="!Intervention.VisaEtab"></i>
                   <i class="fa-solid fa-check text-green-500" v-else></i>
                 </div>
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
       this.UpdatedIntervetion.VisaUae=!this.Interventions[index].VisaUae;

       await axios.patch(
           'http://127.0.0.1:8000/api/Intervention/'+id+'/visauae',
           {VisaUae:this.UpdatedIntervetion.VisaUae}, // Pass the object in the request payload
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
       const response = await axios.get('http://127.0.0.1:8000/api/etablissements/'+this.$route.params.id+'?with=Interventions',config)
       this.Interventions=response.data.data.Interventions
       this.pagecount=response.data.last_page
       console.log(response.data.data.Interventions)
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