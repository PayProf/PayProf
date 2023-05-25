import { createRouter, createWebHistory } from 'vue-router';

//Home page
import Home from '../views/Home.vue';

// UAE
import AdminUAE from "../views/UI/AdminUAE.vue";
import DirecteurUAE from "../views/UI/DirecteurUAE.vue";

//User page
import TableInterventionsUser from '../views/TablesEtab/TableInterventionsUser.vue';

//Admin de l'etablissement
import Admin from '../views/UI/Admin.vue';

//Table etablissement for view only 
import Etablissements from "../views/TablesUAE/TableEtablissements.vue";

//Table Admins et Directeurs for view and edit, concerns the UAE admin
import TableAdmins from "../views/TablesUAE/TableAdmins.vue";
import TableDirecteurs from "../views/TablesUAE/TableDirecteurs.vue";

//Edit forms for admin and directeurs
//import EditAdmins from '../views/UI/EditAdmins.vue';
//import EditDirecteurs from '../views/UI/EditDirecteurs.vue';

//Edit forms for admin and directeurs
import AddIntervention from "../components/AddIntervention.vue";
import PopupForm from "../components/PopupForm.vue";

//Edit forms for directeurs et admin etab
import AddAdmin from "../components/AddAdmin.vue";
import AddDirecteur from "../components/AddDirecteur.vue";

//Edit Profile
import EditProfile from '../components/EditProfile.vue';

//Table intervention for validations
import ValidateIntervention from '../views/TablesEtab/ValidateIntervention.vue'

import DefaultLayout from "../components/DefaultLayout.vue";
import store from "../store.js";
import Notfound from "../views/UI/Notfound.vue";
import { useToast } from "vue-toastification";
import Enseignant from "../views/UI/Enseignant.vue";
import TableInterventionsEnseignant from "../views/UI/TableInterventionsEnseignant.vue";

/******************************************* Routes Configuration *******************************************/

const routes = [

    /*The Login/Home Page */

  {
    path: '/',
    name:'Home',
    component: Home,
    meta:{
      RequiresAuth: false
    }
  },

  {
    path: '/DirecteurUAE',
    name:'DirecteurUAE',
    component: DirecteurUAE,
    // meta:{
    //   RequiresAuth: false
    // }
  },

  /* Table directeurs des établissements home page, concern the uni admin only */
  
  {
    path: '/TableDirecteurs',
    name:'TableDirecteurs',
    component: TableDirecteurs,
    // meta:{
    //   RequiresAuth: false
    // }
  },

  /* Table admins des établissement home page, concern the uni admin only */
  
  {
    path: '/TableAdmins',
    name:'TableAdmins',
    component: TableAdmins,
    // meta:{
    //   RequiresAuth: false :id
    // }
  },

  {
    path: '/TableInterventionsEnseignant/',
    name:'TableInterventionsEnseignant',
    component: TableInterventionsEnseignant ,
    // meta:{
    //   RequiresAuth: false
    // }
  },

  // idE: Enseignant Id,idI: Intervention Id :idE/:idI

  {
    path: '/ValidateIntervention/',
    name:'ValidateIntervention',
    component:ValidateIntervention ,
    // meta:{
    //   RequiresAuth: false
    // }
  },

    //Edit Profile :id

  {
    path: '/EditProfile/',
    name:'EditProfile',
    component:EditProfile ,
    // meta:{
    //   RequiresAuth: false
    // }
  },
 
  // Adding forms 

  {
    path: '/AddAdmins',
    name:'AddAdmins',
    component:AddAdmin ,
    // meta:{
    //   RequiresAuth: false
    // }
  },


  {
    path: '/AddDirecteurs',
    name:'AddDirecteurs',
    component:AddDirecteur ,
    // meta:{
    //   RequiresAuth: false
    // }
  },


  {
    path: '/AddInterventions',
    name:'AddInterventions',
    component:AddIntervention ,
    // meta:{
    //   RequiresAuth: false
    // }
  },

  {
    path: '/AddEnseignants',
    name:'AddEnseignants',
    component:PopupForm ,
    // meta:{
    //   RequiresAuth: false
    // }
  },












 
  /*The Default Layout for all Pages */
  {
    path: '/Dashboard',
    name:'Dashboard',
    component: DefaultLayout,
    meta:{
      RequiresAuth: true,
    },
    children:[
      {
        /*The Page where there's all enseignants */

        path:'/Admin/:Etab',
        name:'Admin',
        component: Admin,
        meta:{
          AdminAccess: true,
          AdminUAEAccess: false,
          UserAccess: false,
        }
      },

      /*The Page where there's the enseignant profile :id */

      {
        path:'/Enseignant/',
        name:'Enseignant',
        component: Enseignant,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: false,
          UserAccess: true,
        }
      },

      /*The Page where there's All the Etablissements for Admin */

      {
        path:'/Adminuae',
        name:'AdminUAE',
        component: AdminUAE,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: true,
          UserAccess: false,
        }
      }
    ]
  },

  /*If the route is undefined this page appears */

  {
    path: '/:catchAll(.*)',
    name: 'NotFound',
    component: Notfound,
  }
];

/*Creating the router*/

const router = createRouter({
  history: createWebHistory(),
  routes,
});

function AccessDenied(toast){
  toast.error('Access Denied',{
    timeout:3000,
  });
}

function ALreadyConnected(toast){
  toast.success('')
}

/*The Page where there's the enseignant profile */

router.beforeEach((to, from, next) => {
  //If the token is present(Authentificated)
  const isAuth = store.state.user.token;
  //the role and privilege
  const usertype = store.state.user.role;
  //is he an admin UAE?
  const isAdminUAE = usertype >= 3;
  //is he an admin (or admin UAE)
  const isAdmin = usertype > 0;
  const toast = useToast();

  //does the page require authentification
  if (to.meta.RequiresAuth) {
    if (!isAuth) //if the user is not authentification
    {
      next({ name: 'Home' });
      AccessDenied(toast);//This one shows notification of access denied
    }
    else //if the user is authentificated
    {
      if(to.name==='Dashboard')
      {
        if(isAdminUAE)
          next({ name: 'AdminUAE' });
        else if(isAdmin)
          next({ name: 'Admin' });
        else
          next({ name: 'Enseignant' });
      }
      else{
      if (to.meta.AdminUAEAccess && !isAdminUAE) //if he's trying to access an adminUAE page and he's not adminUAE
      {
        if (isAdmin) //if he's AdminEtab
        {
          next({ name: 'Admin' });
          AccessDenied(toast);

        }
        else //if he's an enseignant
        {
          next({ name: 'Enseignant' });
          AccessDenied(toast);
        }
      }
      else if (to.meta.AdminAccess && !isAdmin) //if he's trying to access an admin page and he's not an admin
      {
        next({ name: 'Enseignant' });
        AccessDenied(toast);
      }
      else //if he's an enseignant and trying to access his page
      {
          next();
      }
      }
    }
  }
  else //if it doesn't require authentification
  {
    if (isAuth) //and he's authentificated
    {
      if (isAdminUAE) //and he's adminUAE
      {
        next({ name: 'AdminUAE' });
      }
      else if (isAdmin) //and he's adminEtab
      {
        next({ name: 'Admin' });
      }
      else //and he's Enseignant
      {
        next({ name: 'Enseignant'});
      }
    }
    else //and he's not authentificated
    {
      next();
    }
  }
});


export default router;


