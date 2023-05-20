import { createStore } from 'vuex';
import axios from "axios";

export default createStore({
  state: {

    //What we receive from enseignant table we store it here
    enseignants: [
      {
        ppr: "",
        nom: "",
        prenom: "",
        email: "",
      },
    ],
    //the current user connected
    user:
      {
        nom:"",
        prenom:"",
        email: "",
        role:4,
        token:123
      },
      Interventions:[
        {
          
          Id_Intr: "",
          Etablisment: "",
          Intitule_Intervention: "",
          Annee_universitaire: "",
          Semester: "",
          Date_Debut: "",
          Date_Fin: "",
          Nombre_heures: ""
        }
      ]




  },
  getters: {
   
  },
  mutations: {
    
    SetCurrentUser(state,payload){
      state.user=payload;
    },
    setEnseignants (state,payload){
      state.enseignants=payload;
    },
    setInterventions (state,payload){
      state.Interventions=payload;
    },
    addEnseignant(state, enseignants) {
      state.enseignants.push(enseignants);
    },
  },
  actions: {
    async addEnseignant({ commit }, enseignants) {
      try {
        const response = await axios.post('http://localhost:5000/enseignants', enseignant);
        commit('addEnseignant', response.data);
      } catch (error) {
        console.log(error);
      }
    },
    async getInterventions({commit}){
      try{
      const response =await axios.get('http://localhost:5000/Interventions');
      console.log(response.data);
      commit('setInterventions',response.data)
      console.log(this.state.Interventions);

      }
      catch(error){
        console.log(error)
      }
    },
    async getEnseignants({commit}){
      try{
      const response =await axios.get('http://localhost:5000/enseignants');
      commit('setEnseignants',response.data)
      }
      catch(error){
        console.log(error)
      }
    },
    /*
    This is where the login request is made it gets the token
    the user data and stores it in the state
    For now we are gonna only get the user as we are working with JSON serverless
     */
    async getuser({commit}){
      try {
        const response = await axios.get('http://localhost:5000/user');
        commit('SetCurrentUser',response.data)
      }
      catch (error){
        console.log(error)
      }
    },
  },
});
