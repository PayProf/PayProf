<template>
  <div class="mt-10">
   <table class="table table-zebra w-full">
        <!-- head -->
        <thead>
            <tr>
                <th></th>
                <th>PPR</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Grade</th>
                <th>Email</th>
                <th>Etablissement</th>
                <th>Date naissance</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <tr v-for="(Enseignant,index) in this.Enseignants.data" :key="index">
                
                <td>{{ Enseignant.id }}</td>
                <td>{{ Enseignant.PPR }}</td>
                <td>{{ Enseignant.nom }}</td>
                <td>{{ Enseignant.prenom }}</td>
                <td>{{ Enseignant.Grade }}</td>
                <td>{{ Enseignant.DateNaissance }}</td>
                <td>{{ Enseignant.Email }}</td>
                <td>{{ Enseignant.Email }}</td>
                <td>
                    <button class="add-btn" >
                        <i class="fas fa-search"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
  </div>
    

</template>

<script>
import axios from 'axios';
export default {
    name: 'TableEnseignants',
    data() {
    return {
        Enseignants: []
    }
  },

  mounted() {
    this.getEnseignants();


  },
  methods: {
    async getEnseignants() {
      try {
        await axios.get('http://127.0.0.1:8000/api/Enseignant').then(result=>{
          this.Enseignants = result.data

        })
        console.log(this.Enseignants.data)

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