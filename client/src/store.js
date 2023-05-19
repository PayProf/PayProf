import { createStore } from 'vuex';
import axios from "axios";
import axiosinstance from "./axios.js";
import user from "./views/UI/User.vue";

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
        role: "",
        token:""
      },




  },
  getters: {
    getEnseignants: (state) => {
      return state.enseignants;
    },
  },
  mutations: {
    addEnseignant: (state, enseignant) => {
      state.enseignants.push(enseignant);
    },
    SetCurrentUser(state,payload){
      state.user=payload;
    }
  },
  actions: {
    addEnseignant: (context, enseignant) => {
      context.commit('addEnseignant', enseignant);
    },
    /*
    This is where the login request is made it gets the token
    the user data and stores it in the state
     */

    async getuser({commit}){
      try {
        const response = await axios.get('http://localhost:5000/user');
        console.log(response.data)
        commit('SetCurrentUser',response.data)

      }
      catch (error){
        console.log(error)
      }
    },
  },
});
