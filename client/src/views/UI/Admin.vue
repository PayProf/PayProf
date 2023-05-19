<template style="margin-top: 100px;">

<div class="hero min-h-screen bg-base-200">
  <div class="hero-content flex-col lg:flex-row">
    
    <div>
      <h1 class="text-5xl font-bold">Welcome Home Admin </h1>
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
    <h1 style=" margin-top: 0px;">Table Enseignaint :</h1>
    <div class="search-bar-container">
      
    <input type="text" class="search-bar" v-model="searchText" placeholder="Search" @input="filterTable">
  </div>
  <table class="table table-zebra w-full">
    <!-- head -->
    <thead>
        <tr>
            <th><input type="checkbox" /></th>
            <th>PPR</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
    </thead>
    <tbody>
  <!-- This import the users from store.state in the table -->
          <tr v-for="(enseignant,index) in $store.state.enseignants " :key="index">
            <td><input type="checkbox" /></td>
            <td>{{ enseignant.ppr }}</td>
            <td>{{  enseignant.nom  }}</td>
            <td>{{ enseignant.prenom }}</td>
            <td>{{enseignant.email }}</td>
            <td><button class="delete-btn">
                <i class="fas fa-trash"></i>
                 <span class="tooltip" data-tooltip="Delete">Supprimer enseignant</span>
                 </button>
                 <button class="add-btn">
                    <i class="fas fa-plus"></i>
                   <span class="tooltip" data-tooltip="Add">ajouter enseignant</span>
                  </button>
                  <button class="add-btn" @click="showPopupForm = true">
                    <i class="fas fa-search"></i>
                    <span class="tooltip" data-tooltip="inspect">voir profile</span>
                  </button></td>
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
<PopupForm />
  </template>
  

<script>
import PopupForm from '/src/components/PopupForm.vue';
export default {
  name: 'Admin',
  components: {
    PopupForm,
  },
  data() {
    return {
      showPopupForm: false,
    };
  },
  methods: {
    showPopup() {
      this.showPopupForm = true;
    },
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