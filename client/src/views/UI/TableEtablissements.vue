<template>
  
  <!-- TABLE ETABLISSEMENT -->
  <div class="overflow-x-auto border">
  <table class="table w-screen botrder">
    <!-- head -->
    <thead>
      <tr >
        <th></th>
        <th>PPR</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email Personnel</th>
        <th>Nombre enseignants</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>
  </table>
</div>
 
</template>

<script>
import { mapState } from 'vuex'

export default {

  name: 'Etablissements',
  components: {

  },

  computed: {
    ...mapState([
      'user',

    ])
  }

}
</script>

<style></style>