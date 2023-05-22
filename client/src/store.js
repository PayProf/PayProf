import { createStore } from 'vuex';
import axios from "axios";
import jwtDecode from "jwt-decode";
import { useToast } from "vue-toastification";
import router from "./router/index.js";

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
        id:localStorage.getItem('USERID'),
        email:localStorage.getItem('EMAIL'),
        role:localStorage.getItem('ROLE'),
        token:localStorage.getItem('TOKEN'),
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

    /*
    Here's the mutation that changes the current state when logged in
     */
    
    SetCurrentUser(state,payload){
      state.user.token=payload.token;
      localStorage.setItem('TOKEN',payload.token);
      state.user.role=payload.user.role;
      localStorage.setItem('ROLE',payload.role);
    },

    ResetCurrentUser(state){
      localStorage.clear();
      state.user.token=null;
    },


    setEnseignants (state,payload){
      state.enseignants=payload;
    },
    setInterventions (state,payload){
      state.Interventions=payload;
    },
    addEnseignant(state, enseignants){
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
    the user data and stores it in the state Abcd314!
     */
    async login({commit},FormData){
      try {
        const response = await axios.post('login',FormData);
        commit('SetCurrentUser',response.data.data)
        router.push('/Dashboard')
      }
      catch (error){
        console.log(error)
        router.push('/')
        const toast=useToast();
        toast.error('Invalid Credentials',{
          timeout:3000,
        });

      }
    },
    /*
    This is where the logout request it sends a post request and received a message
    if the user is not authentificated it directly log him out, if he's authentificated
    it logs him out and resets the state
     */
    async logout({commit}){
      try{
        const token = localStorage.getItem('TOKEN'); // Here i used localstorage but later will change it to state
        console.log(token)
        const config = {
          headers: {Authorization: `Bearer ${token}`}
        };
        const response = await axios.post('logout',null,config);
        console.log(response)
        commit('ResetCurrentUser')
        console.log('Reset Succesful')
        router.push('/');
      }
      catch(error){
        console.log(error)
        if (error.response && error.response.status === 401){
          commit('ResetCurrentUser');
          router.push('/');
        }
        const toast=useToast();
        toast.error("Something's Wrong :(",{
          timeout:3000,
        });
      }
    }
  },
});
