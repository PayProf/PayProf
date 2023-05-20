import { createStore } from 'vuex';
import axios from "axios";
import jwtDecode from "jwt-decode";

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
        id:sessionStorage.getItem('USERID'),
        email:sessionStorage.getItem('EMAIL'),
        role:sessionStorage.getItem('ROLE'),
        token:sessionStorage.getItem('TOKEN'),
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
      sessionStorage.setItem('TOKEN',payload.token);
      state.user.role=payload.role;
      sessionStorage.setItem('ROLE',payload.role);
      const DecodedToken = jwtDecode(payload.token);
      state.user.email=DecodedToken.email;
      sessionStorage.setItem('EMAIL',DecodedToken.email);
      state.user.id=DecodedToken.id;
      sessionStorage.setItem('USERID',DecodedToken.id);
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
    the user data and stores it in the state
     */
    async login({commit},FormData){
      try {
        const response = await axios.post('/login',FormData);
        commit('SetCurrentUser',response.data)
        router.push('/Dashboard')
      }
      catch (error){
        console.log(error)
        router.push('/')
      }
    },
  },
});
