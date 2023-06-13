<template>
   <div class="card card-side bg-base-100 shadow-xl  mx-64">
        <div class="card-body">
          <h1 class="text-2xl font-bold">Etablissement {{Etablissements.nom}}</h1>
          <p class="py-2"><strong>Nom :</strong>{{this.Etablissements.code}}</p>
          <p class="py-2"><strong>Ville:</strong> {{this.Etablissements.ville}}</p>
          <p class="py-2"><strong>Telephone :</strong> {{this.Etablissements.Telephone}}</p>
          <p class="py-2"><strong>Fax :</strong> {{this.Etablissements.FAX}}</p>
          <p class="py-2"><strong>Nombre Enseignant :</strong> {{this.Etablissements.Nombre_des_enseignants}}</p>
          
          
        </div>
      </div>
 <TableEnseignant/> 
</template>

<script >
import TableEnseignant from '../TablesEtab/TableEnseignant.vue'
import store from "../../store"
import axios from 'axios';


export default {
    data(){
        return{
            EtablissementId:"",
            Etablissements:[],
        }
        

    },
    components:{
        TableEnseignant
    },
    mounted(){
        this.getEtablissement();
    },
    methods:{
         getEtablissement(){
      try {
        this.EtablissementId = this.$route.params.id;
        console.log(this.EtablissementId)
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        console.log('test axios')
         axios.get('http://127.0.0.1:8000/api/etablissements/'+this.$route.params.id,config).then(result=>{
          console.log('test axios')
          this.Etablissements = result.data.data
          console.log(this.Etablissements)
        })
        console.log(this.Etablissement.data)

      }
      catch (error) {
        console.log(error)
      }
    },
    }

}
</script>

<style>
.card{
    margin-top: 10%;
}
</style>