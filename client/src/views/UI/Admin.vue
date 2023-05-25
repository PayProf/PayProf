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
    <h1 style=" margin-top: 0;">Table Enseignaint :</h1>
    <div class="form-control">
  <div class="input-group">
    <input type="text" placeholder="Search…" class="input input-bordered" />
    <button class="btn btn-square">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
    </button>
  </div>
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
          <tr v-for="(enseignant) in enseignants" :key="enseignant.ppr">
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
import PopupForm from '../../components/PopupForm.vue';
import {mapActions,mapState} from 'vuex';
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
    ...mapActions([
      'getEnseignants'
  ]),
    showPopup() {
      this.showPopupForm = true;
    },
  },
  computed:{
    ...mapState([
        'enseignants',
    ])
  },
  async created(){
    await this.$store.dispatch('getEnseignants');
  }
};


</script>

<style scoped>
  .delete-btn,
  .add-btn,

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

</style>