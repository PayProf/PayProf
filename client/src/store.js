import { createStore } from 'vuex';
import axios from "axios";
import { useToast } from "vue-toastification";
import router from "./router/index.js";

const store = createStore({
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
      nom: "mouad",
      prenom: "hayaoui",
      id: localStorage.getItem('USERID'),
      email: localStorage.getItem('EMAIL'),

      role: 0,//localStorage.getItem('ROLE'),
      token: localStorage.getItem('TOKEN'),
      token_exp: localStorage.getItem('EXPIRATION')
    },

    Interventions: [
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
    ],

    Admins: [
      {
        ppr: "",
        nom: "",
        prenom: "",
        email: "",
        role: 2
      }
    ],

    EtabDirecteurs: [
      {
        ppr: "",
        nom: "",
        prenom: "",
        email: "",
        role: 1,

      }
    ],

    Etablisment: [
      {
        code: "",
        nom: "",
        telephone: "",
        fax: "",
        ville: "",
        nbrEnseignant: "",

      },
    ],






  },
  getters: {

    IsExpired(state) {
      const Exp = new Date(state.user.token_exp);

      const current = new Date();

      return Exp < current;
    
    },

  },
  mutations: {


    /*
    Here's the mutation that changes the current state when logged in
     */

    SetCurrentUser(state, payload) {
      state.user.token = payload.token;
      localStorage.setItem('TOKEN', payload.token);
      state.user.role = payload.role;
      localStorage.setItem('ROLE', payload.role);

      //get the current date
      const currentDate = new Date();
      //Add hours till expiration to it
      const Exp = new Date(currentDate.getTime() + (60 * 60 * 1000) + (59 * 60 * 1000));

      //storing the date as a string
      state.user.token_exp = Exp.toISOString();
      localStorage.setItem('EXPIRATION', Exp.toISOString());

    },

    /*Resets the state*/

    ResetCurrentUser(state) {
      localStorage.clear();
      state.user.token = null;
    },

    /*Manages the state of the access token and refresh token*/

    RefreshToken(state, payload) {
      state.user.token = payload.token;
      localStorage.setItem('TOKEN', payload.token)

      //get the current date
      const currentDate = new Date();
      //Add hours till expiration to it
      const Exp = new Date(currentDate.getTime() + (60 * 60 * 1000) + (59 * 60 * 1000));

      //storing the date as a string
      state.user.token_exp = Exp.toISOString();
      localStorage.setItem('EXPIRATION', Exp.toISOString());
    },


    /*Set Enseignants */

    setEnseignants(state, payload) {
      state.enseignants = payload;
    },

    /* Set Interventions */
    setInterventions(state, payload) {
      state.Interventions = payload;
    },

    /* Add Enseignant */
    addEnseignant(state, enseignants) {

      state.enseignants.push(enseignants);
    },

    /* Add Etablisment */
    addEtablisment(state, playload) {
      state.Etablisment = playload;
    },

    /* Set Etablissement */
    setEtablisment(state, payload) {
      state.enseignants = payload;
    },


  },
  actions: {

    async addEnseignant({ commit }, enseignants) {
      try {
        const response = await axios.post('http://localhost:5000/enseignants', enseignants);
        commit('addEnseignant', response.data);
      } catch (error) {
        console.log(error);
      }
    },


    async addEtablisment({ commit }, payload) {
      try {
        let url = '/save-etablissemnt';
        await axios.post(url, payload).then(result => {
          commit('addEtablisment', result.data);
        })

      } catch(error) {
        console.log(error)
        await router.push('/')
        const toast=useToast();
        toast.error('Something went wrong',{
          timeout:3000,
        });
      }
    },

    async getEtablisment({ commit } , playload) {
      try{
        let url='get-etablissement';
        await axios.post(url,playload).then(result=>{
          commit('setEtablisment',result.data)
        })
      }catch(error){
        console.log(error)
        await router.push('/TableEtablissements')
        const toast = useToast();
        toast.error('Error fetching', {
          timeout: 3000,
        });
      }
      

    },



    // async getInterventions({commit}){
    //   try{
    //   const response =await axios.get('http://localhost:5000/Interventions');
    //   console.log(response.data);
    //   commit('setInterventions',response.data)
    //   console.log(this.state.Interventions);
    //
    //   }
    //   catch(error){
    //     console.log(error)
    //   }
    // },
    // async getEnseignants({commit}){
    //   try{
    //   const response =await axios.get('http://localhost:5000/enseignants');
    //   commit('setEnseignants',response.data)
    //   }
    //   catch(error){
    //     console.log(error)
    //   }
    // },

    /*
    This is where the login request is made it gets the token
    the user data and stores it in the state
     */
    async login({ commit }, FormData) {
      try {
        const response = await axios.post('login', FormData);
        commit('SetCurrentUser', response.data.data)
        await router.push('/Dashboard')
      }
      catch (error) {
        console.log(error)
        await router.push('/')
        const toast = useToast();
        toast.error('Invalid Credentials', {
          timeout: 3000,
        });

      }
    },
    /*
    This is where the logout request it sends a post request and received a message
    if the user is not authentificated it directly log him out, if he's authentificated
    it logs him out and resets the state
     */
    async logout({ commit }) {
      try {
        const token = localStorage.getItem('TOKEN'); // Here i used localstorage but later will change it to state
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        };
        await axios.get('logout', config);
        commit('ResetCurrentUser')
        await router.push('/');
      }
      catch (error) {
        console.log(error)
        if (error.response && error.response.status === 401) {
          commit('ResetCurrentUser');
          await router.push('/');
        }
        const toast = useToast();
        toast.error("Something's Wrong :(", {
          timeout: 3000,
        });
      }
    },
    /* it's time for refresh token, when the user's token is no longer
    valid he automatically gets his token refreshed
     */
    async RefreshToken({ commit }) {
      try {
        const token = store.state.user.token;
        const config = {
          headers: { Authorization: `Bearer ${token}` }
        }
        const response = await axios.get('refresh',config)
        commit('RefreshToken',response.data.data)
      }
      catch (error) {
        console.log(error)
        if (error.response && error.response.status === 401) {
          commit('ResetCurrentUser');
          await router.push('/');
        }
        const toast = useToast();
        toast.error("Something's Wrong :(", {
          timeout: 3000,
        });

      }
    }
  },
});


export default store;