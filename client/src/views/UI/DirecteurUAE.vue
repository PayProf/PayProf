<template>
    <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12">
    <div class="col-span-1">
      <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-50" v-drag>
        
        <li @click="toggleTableAdmin()" v-if="showAdmin" class="bg-neutral text-white Interventions">
          <i class="fa-solid fa-users"></i>
        </li>
        <li @click="toggleTableAdmin()" v-else class="Interventions">
          <i class="fa-solid fa-users"></i>
        </li>
        <li @click="toggleTableDirecteur()" v-if="showDir" class="bg-neutral text-white">
          <i class="fa-solid fa-suitcase"></i>
        </li>
        <li @click="toggleTableDirecteur()" v-else>
          <i class="fa-solid fa-suitcase"></i>
        </li>
        <li @click="toggleTableEtablissement()" v-if="showEtablissement" class="bg-neutral text-white">
          <i class="fa-solid fa-school"></i>
        </li>
        <li @click="toggleTableEtablissement()" v-else>
          <i class="fa-solid fa-school"></i>
        </li>

        <li>
          <i class="fa-solid fa-arrows-up-down-left-right"></i>
        </li>
      </ul>
    </div>

  </div>
  <TableDirecteurs v-if="showDir" />
  <TableEtablissements v-if="showEtablissement"/>
</template>

<script>
export default {
    name: "DirecteurUAE",
    methods:{
        redirectTableIntervention(){
            this.$router.push('/ValidateInterventionUAE')
        },
        redirectTableDirecteur(){
            this.$router.push('/TableDirecteurs')
        },
       

    }
}
</script>

<style></style>