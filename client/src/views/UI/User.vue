<template>
<div class="hero min-h-screen bg-base-200">
  <div class="hero-content flex-col lg:flex-row">
    
    <div>
        <!-- here I need to add the name of the user inspected -->
      <h1 class="text-5xl font-bold">User: mouad</h1>
      <!-- information about the user that needs to be emited  -->
      <p class="py-6">Nom : Hayaoui</p>
      <p class="py-6">Prenom :  Mouad</p>
      <p class="py-6">email : Hayaouimouad@gmail.com</p>
      <p class="py-6">etablissment : ensa</p>
      <p class="py-6"></p>
      <button class="btn btn-primary">Get Started</button>
    </div>
  </div>
</div>
<div class="overflow-x-auto" style="margin-left: 20px; margin-right: 50px;">
    <h1 style=" margin-top: 0px;">Table Intervention :</h1>
    <div class="search-bar-container">
      
    <input type="text" class="search-bar" v-model="searchText" placeholder="Search" @input="filterTable">
  </div>
  <table class="table table-zebra w-full">
    <!-- head -->
    <thead>
        <tr>
            <th><input type="checkbox" /></th>
            <th>Id_Intr</th>
            <th>Etablisment</th>
            <th>Intitule_Intervention</th>
            <th>Annee universitaire</th>
            <th>Semester</th>
            <th>Date Debut</th>
            <th>Date Fin</th>
            <th>Nombre heures</th>
            <th>Action</th>
          </tr>
    </thead>
    <tbody>
      <tr>
        <th><input type="checkbox" /></th>
        <td>Cy Ganderton</td>
        <td>Quality Control Specialist</td>
        <td>Blue</td>
        <td>jane@example.com</td>
        <td>Cy Ganderton</td>
        <td>Quality Control Specialist</td>
        <td>Blue</td>
        <td>jane@example.com</td>
        
        <td>
        <button class="delete-btn">
        <i class="fas fa-trash"></i>
        <span class="tooltip" data-tooltip="Delete">Supprimer intervention </span>
        </button>
        <button class="inspect-btn">
        <i class="fas fa-edit"></i>
        <span class="tooltip" data-tooltip="Inspect">modify intervention </span>
        </button>
      </td>
        </tr>
      <!-- row 2 -->
      <tr>
        <th><input type="checkbox" /></th>
        <td>Cy Ganderton</td>
        <td>Quality Control Specialist</td>
        <td>Blue</td>
        <td>jane@example.com</td>
        <td>Cy Ganderton</td>
        <td>Quality Control Specialist</td>
        <td>Blue</td>
        <td>jane@example.com</td>
        
        <td>
        <button class="delete-btn">
        <i class="fas fa-trash"></i>
        <span class="tooltip" data-tooltip="Delete">Supprimer intervention </span>
        </button>
        <button class="inspect-btn">
        <i class="fas fa-edit"></i>
        <span class="tooltip" data-tooltip="Inspect">modify intervention </span>
        </button>
      </td>
        </tr>
      <!-- row 3 -->
      <tr>
        <th><input type="checkbox" /></th>
        <td>Cy Ganderton</td>
        <td>Quality Control Specialist</td>
        <td>Blue</td>
        <td>jane@example.com</td>
        <td>Cy Ganderton</td>
        <td>Quality Control Specialist</td>
        <td>Blue</td>
        <td>jane@example.com</td>
        
        <td>
        <button class="delete-btn">
        <i class="fas fa-trash"></i>
        <span class="tooltip" data-tooltip="Delete">Supprimer intervention </span>
        </button>
        <button class="inspect-btn">
        <i class="fas fa-edit"></i>
        <span class="tooltip" data-tooltip="Inspect">modify intervention </span>
        </button>
      </td>
        </tr>

          <tr v-for="row in filteredData" :key="row.id">
            <td>{{ row.ppr }}</td>
            <td>{{  row.nom  }}</td>
            <td>{{ row.prenom }}</td>
            <td>{{row.emaill }}</td>
            <td><button class="delete-btn" ><i class="fas fa-trash"></i></button><button class="inspect-btn"><i class="fas fa-search"></i></button><button class="add-btn"><i class="fas fa-plus"></i></button></td>

            <td>
              <button class="btn btn-danger btn-sm">
                <i class="fa fa-trash" aria-hidden="true"></i>
              </button>
            </td>
          </tr>
        </tbody>
  </table>
</div>
<div class="btn-group" style="display: flex; justify-content: center; margin-top: 30px;">
  <button class="btn">1</button>
  <button class="btn btn-active">2</button>
  <button class="btn">3</button>
  <button class="btn">4</button>
</div>
</template>

<script>
export default {
    name:'User',
}
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
    margin-right: 20px;
    
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