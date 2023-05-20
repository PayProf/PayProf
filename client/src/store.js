import { createStore } from 'vuex';
import axios from "axios";
import axiosinstance from "./axios.js";
import user from "./views/UI/User.vue";

export default createStore({
  state: {

    //What we receive from enseignant table we store it here
    enseignants: [
      {
        ppr: "1",
        nom: "Mouad",
        prenom: "Hyaoui",
        email: "mouadhayaoui@exemple.com",
      },
      {
        ppr: "1",
        nom: "Mouad",
        prenom: "Hyaoui",
        email: "mouadhayaoui@exemple.com",
      },
      {
        ppr: "1",
        nom: "Mouad",
        prenom: "Hyaoui",
        email: "mouadhayaoui@exemple.com",
      },
    ],
    //the current user connected
    user:
      {
        nom:"",
        prenom:"",
        email: "",
        role:0,
        token:123
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
    For now we are gonna only get the user as we are working with JSON serverless
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
