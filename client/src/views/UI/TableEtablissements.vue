<template>
  
  <!-- TABLE ETABLISSEMENT -->
  <div class="overflow-x-auto border">
  <table class="table w-screen botrder">
    <!-- head -->
    <thead>
      <tr v-for="(etablissement,id) in etablissements" :key="id">
        <th></th>
        <th>Nom</th>
        <th>Télephone</th>
        <th>Fax</th>
        <th>Ville</th>
        <th>Nombre enseignants</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>
  </table>
</div>
<PopupForm />

</template>

<script>
import PopupForm from '/src/components/PopupForm.vue';
import { mapState, mapGetters } from 'vuex'


export default {

  name: 'Etablissements',
  components: {
    PopupForm
  },
  data(){
    return{
      etablissements: [
        {
          id:"",
          nom:"",
          telephone:"",
          fax:"",
          ville:"",
          nbrEnseignants:"",

        }
      ],
    }
  },
  mounted(){
    this.$store.dispatch('getEtablissements')
  },
  computed: {
    ...mapGetters({
      etablissements: 'etablissements'
    })
  }

}
</script>

<style></style>