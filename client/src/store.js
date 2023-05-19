import { createStore } from 'vuex';

export default createStore({
  state: {
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
