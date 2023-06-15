<template>
  <div class="p-4 mt-20 min-h-screen sm:mx-30 grid grid-cols-12">
    <div class="col-span-1">
      <ul class="menu bg-base-200 rounded-box mt-6 w-12 z-50" v-drag>
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
    <div class="col-span-11">
      <div class="card card-side bg-base-100 shadow-xl">
        <div class="card-body mb-3">
          <h1 class="text-2xl font-bold text-center">Bonjour Directeur UAE</h1>
        </div>
      </div>
      <div class=" mt-3">
        <TableDirecteurs v-if="showDir" />
        <TableEtablissements v-if="showEtablissement"/>
      </div>

    </div>
  </div>

</template>

<script>
import TableDirecteurs from '../TablesUAE/TableDirecteurs.vue'
import TableEtablissements from '../TablesUAE/TableEtablissements.vue'
export default {
  name: "DirecteurUAE",
  components:{
    TableDirecteurs,
    TableEtablissements
  },
  data(){
    return{
      showDir: false,
      showEtablissement: true,
    }
  },
  methods:{
    toggleTableEtablissement(){
      this.showEtablissement = !this.showEtablissement
    },
    toggleTableDirecteur(){
      this.showDir = !this.showDir
    },


  }
}
</script>

<style></style>