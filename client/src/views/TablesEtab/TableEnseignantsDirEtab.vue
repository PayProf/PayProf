<template>
  <div class="mt-10">
    <table class="table table-zebra w-full">
      <!-- head -->
      <thead>
        <tr>
          <th></th>
          <th>Code</th>
          <th>Nom</th>
          <th>Télephone</th>
          <th>Fax</th>
          <th>Nombre Etablissements</th>
          <!-- Consulter la table des Etablissements de cet etablissement -->
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(Etablissement, index) in this.Etablissements.data" :key="index">

          <td>{{ Etablissement.id }}</td>
          <td>{{ Etablissement.code }}</td>
          <td>{{ Etablissement.Nom }}</td>
          <td>{{ Etablissement.Telephone }}</td>
          <td>{{ Etablissement.ville }}</td>
          <td>{{ Etablissement.Nombre_des_Etablissements }}</td>

          <td>
            <router-link :to="{ path: '/Etablissement/' + Etablissement.id }">
              <button class="add-btn px-4">
                <i class="fas fa-eye"></i>
                <span class="tooltip" data-tooltip="inspect"></span>
              </button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'TableEtablissements',
  data() {
    return {
      Etablissements: []
    }
  },

  mounted() {
    this.getEtablissements();


  },
  methods: {
    async getEtablissements() {
      try {
        await axios.get('http://127.0.0.1:8000/api/Etablissement').then(result => {
          this.Etablissements = result.data

        })
        console.log(this.Etablissements.data)

      }
      catch (error) {
        console.log(error)
      }
    }
  },
};


</script>
<style scoped>
.delete-btn,
.add-btn,
.inspect-btn {
  position: relative;
  display: inline-block;
  padding: 0;
  border: none;
  background: none;
  cursor: pointer;
  margin-right: 10px;

}

.tooltip {
  position: absolute;
  background-color: gray;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  visibility: hidden;
  opacity: 0;
  transition: opacity 0.2s, visibility 0s linear 0.2s;
  pointer-events: none;
  white-space: nowrap;
}

.delete-btn:hover .tooltip,
.add-btn:hover .tooltip,
.inspect-btn:hover .tooltip {
  visibility: visible;
  opacity: 1;
  transition-delay: 0s;
}

.tooltip:before {
  content: attr(data-tooltip);
  position: absolute;
  top: -25px;
  left: 50%;
  transform: translateX(-50%);
}

.search-bar-container {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 10px;
}

.search-bar {
  width: 200px;
  margin-left: 10px;
}
</style>