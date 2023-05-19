import { createStore } from 'vuex';

export default createStore({
  state: {
    enseignants: [
      {
        ppr: "",
        nom: "",
        prenom: "",
        email: "",
      },
    ],
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
  },
  actions: {
    addEnseignant: (context, enseignant) => {
      context.commit('addEnseignant', enseignant);
    },
  },
});
