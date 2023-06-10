import { createRouter, createWebHistory } from 'vue-router';

//Home page
import Home from '../views/Home.vue';

// UAE
import AdminUAE from "../views/UI/AdminUAE.vue";
import DirecteurUAE from "../views/UI/DirecteurUAE.vue";



//Admin de l'etablissement
import Admin from '../views/UI/Admin.vue';

//Directeur de l'etablissement
import EtabDirector from "../views/UI/EtabDirector.vue";
import TableEtablissement from "../views/TablesUAE/TableEtablissements.vue"


//Table Admins et Directeurs for view and edit, concerns the UAE admin
import TableAdmins from "../views/TablesUAE/TableAdmins.vue";
import TableDirecteurs from "../views/TablesUAE/TableDirecteurs.vue";
import TableEnseignants from "../views/TablesEtab/TableEnseignant.vue";


//Edit forms for admin and directeurs
import AddIntervention from "../components/AddIntervention.vue";
import PopupForm from "../components/AddEnseignant.vue";

//Edit forms for directeurs et admin etab
import AddAdmin from "../components/AddAdmin.vue";
import AddDirecteur from "../components/AddDirecteur.vue";

//Edit Profile
import EditProfile from '../components/EditProfile.vue';
import EditAdmin from '../components/EditAdmin.vue'

//Table intervention for validations
import ValidateIntervention from '../views/TablesEtab/ValidateIntervention.vue'

import DefaultLayout from "../components/DefaultLayout.vue";
import store from "../store.js";
import Notfound from "../views/UI/Notfound.vue";
import { useToast } from "vue-toastification";
import TableInterventionsEnseignant from "../views/UI/TableInterventionsEnseignant.vue";
import User from "../views/UI/User.vue";

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
        path: '/DirecteurUAE',
        name:'DirecteurUAE',
        component: DirecteurUAE,
        meta:{
        AdminAccess: false,
        AdminUAEAccess: false,
        UserAccess: false,
        DirectorUAEAccess: true,
        DirectorAccess:false,
        }
      },

      {
        path: '/Directeur',
        name:'Directeur',
        component: EtabDirector,
        meta:{
        AdminAccess: false,
        AdminUAEAccess: false,
        UserAccess: false,
        DirectorUAEAccess: false,
        DirectorAccess:true,
        }
      },

      /* Table directeurs des établissements home page, concern the uni admin only */
      {
        path: '/TableDirecteurs',
        name:'TableDirecteurs',
        component: TableDirecteurs,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: true,
          UserAccess: false,
          DirectorUAEAccess: true,
          DirectorAccess:false,
        }
      },
     

      /* Table admins des établissement home page, concern the uni admin only */
      {
        path: '/TableAdmins',
        name:'TableAdmins',
        component: TableAdmins,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: true,
          UserAccess: false,
          DirectorUAEAccess: false,
          DirectorAccess:false,
        }
      },
     

      {
        path: '/TableInterventionsEnseignant/',
        name:'TableInterventionsEnseignant',
        component: TableInterventionsEnseignant ,
        meta:{
          AdminAccess: true,
          AdminUAEAccess: true,
          UserAccess: true,
          DirectorUAEAccess: true,
          DirectorAccess:true,
        }
      },

      // idE: Enseignant Id,idI: Intervention Id :idE/:idI

      {
        path: '/ValidateIntervention/',
        name:'ValidateIntervention',
        component:ValidateIntervention ,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: false,
          UserAccess: false,
          DirectorUAEAccess: true,
          DirectorAccess:true,
        }
      },

      //Edit Profile :id

      {
        path: '/EditProfile/',
        name:'EditProfile',
        component:EditProfile ,
        meta:{
          AdminAccess: true,
          AdminUAEAccess: true,
          UserAccess: true,
          DirectorUAEAccess: true,
          DirectorAccess:true,
        }
      },

      // Adding forms

      {
        path: '/AddAdmins',
        name:'AddAdmins',
        component:AddAdmin ,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: true,
          UserAccess: false,
          DirectorUAEAccess: false,
          DirectorAccess:false,
        }
      },


      {
        path: '/AddDirecteurs',
        name:'AddDirecteurs',
        component:AddDirecteur ,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: true,
          UserAccess: false,
          DirectorUAEAccess: false,
          DirectorAccess:false,
        }
      },



      {
        path: '/EditAdmin/:id ',
        name:'EditAdmin ',
        component: EditAdmin,
        // meta:{
        //   RequiresAuth: false
        // }
      },



      {
        path: '/TableEnseignants',
        name:'TableEnseignants',
        component: TableEnseignants,
        // meta:{
        //   RequiresAuth: false
        // }
      },

      {
        path: '/TableEtablissement',
        name:'TableEtablissement',
        component: TableEtablissement,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: true,
          UserAccess: false,
          DirectorUAEAccess: true,
          DirectorAccess:false,
        }
      },


      {
        path: '/AddInterventions',
        name:'AddInterventions',
        component:AddIntervention ,
        meta:{
          AdminAccess: false,
          AdminUAEAccess: false,
          UserAccess: true,
          DirectorUAEAccess: false,
          DirectorAccess:false,
        }
      },

      {
        path: '/AddEnseignants',
        name:'AddEnseignants',
        component:PopupForm ,
        meta:{
          AdminAccess: true,
          AdminUAEAccess: true,
          UserAccess: false,
          DirectorUAEAccess: false,
          DirectorAccess:false,
        }
      },
        /*The Page where there's all enseignants */

      {
        path:'/Admin/',
        name:'Admin',
        component: Admin,
        meta:{
          AdminAccess: true,
          AdminUAEAccess: false,
          UserAccess: false,
          DirectorUAEAccess: false,
          DirectorAccess:false,
        }
      },

      /*The Page where there's the enseignant profile :id */

      {
        path:'/Enseignant/',
        name:'Enseignant',
        component: User,
        meta:{
          AdminAccess: true,
          AdminUAEAccess: true,
          UserAccess: true,
          DirectorUAEAccess: true,
          DirectorAccess:true,
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
          DirectorUAEAccess: false,
          DirectorAccess:false,
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

function AlreadyConnected(toast){
  toast.success('Already Connected',{
    timeout:3000,
  });
}

/*The Page where there's the enseignant profile */

router.beforeEach((to, from, next) => {
  //If the token is present(Authentificated)
  const isAuth = store.state.user.token;
  //the role and privilege
  const usertype = store.state.user.role;
  //is he an admin UAE?
  const isAdminUAE = (parseInt(usertype)===4);
  //is he a DirectorUAE?
  const isDirectorUAE = (parseInt(usertype)===3);
  //is he an admin?
  const isAdmin = (parseInt(usertype)===2);
  //is he a Director?
  const isDirector = ((parseInt(usertype)===1));
  //is he an Enseignant
  const isEnseignant = ((parseInt(usertype)===0));
  //Notification
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
      if(to.name==='Dashboard')//if he's redirected to dashboard
      {
        if(isAdminUAE)//if he's AdminUAE
          next({ name: 'AdminUAE' });
        else if(isAdmin)//if he's Admin
          next({ name: 'Admin' });
        else if(isDirector)//if he's Director
          next({ name: 'Directeur'});
        else if(isDirectorUAE)//if he's DirectorUAE
          next({ name: 'DirecteurUAE'})
        else//if he's Enseignant
          next({ name: 'Enseignant' });
      }
      else//Any other Page
      {
        if (isAdminUAE && !to.meta.AdminUAEAccess)//if AdminUAE doesn't Have access
        {
          next({name:'Dashboard'});
          AccessDenied(toast);
        }
        else if (isAdmin && !to.meta.AdminAccess)//if Admin doesn't Have access
        {
          next({name:'Dashboard'});
          AccessDenied(toast);
        }
        else if (isDirectorUAE && !to.meta.DirectorUAEAccess)//if DirectorUAE doesn't Have access
        {
          next({name:'Dashboard'});
          AccessDenied(toast);
        }
        else if (isDirector && !to.meta.DirectorAccess) //if Director doesn't Have access
        {
          next({name:'Dashboard'});
          AccessDenied(toast);
        }
        else if (isEnseignant && !to.meta.UserAccess) //if Enseignant doesn't Have access
        {
          next({name:'Dashboard'});
          AccessDenied(toast);
        }
        else // if he has access
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
      next({name:'Dashboard'});
      AlreadyConnected(toast);
    }
    else //and he's not authentificated
    {
      next();
    }
  }
});


export default router;


