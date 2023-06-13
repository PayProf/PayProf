<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Administrateur;
use App\Models\Directeur;
use App\Models\Enseignant;
use App\Models\Intervention;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('check_role', function ($user, ...$roles) {
            $userRole = $user->role;

            if (in_array($userRole, $roles)) {
                return true;
            } else {
                return false;
            }
        });

        //in ADMINISTRATEUR controller(function show)
        Gate::define('can_admin', function (User $user, $id) {
            $administrateur = Administrateur::find($id);

            if($administrateur &&  $administrateur->user_id==$user->id && $user->role==2){
                return true;
            }

        });

      //in ADMINISTRATEUR controller(Check if admin can show only his own profil or update his own email )
        Gate::define('admin_modify', function (User $user, $user_id) {
            if($user->id==$user_id){
                return true;
            }

        });
        
                          //IN DIRECTEUR CONTROLLER : 


        //check if admin_etb can show only "les directeures de ses etablissements"
        Gate::define('admin_direct', function (User $user, $id) {
            $directeur = Directeur::find($id);
            $admin = Administrateur::where('user_id', $user->id)->first();
        
            if ($directeur && $admin && $directeur->etablissement_id == $admin->etablissement_id && $user->role==2) {

                return true;
            }

            return false;
        });
        //Check if "directeur" can show only his own profil
        Gate::define('direct_himself', function (User $user, $id) {

            $direct =Directeur::find($id);
        
            if ($direct && $direct->user_id==$user->id && $user->role==1) {

                return true;
            }

            return false;
        });

        ///////////////////// IN ENSEIGNAT CONTROLLER  ///////////

      // check if  "directeur" can show "enseignant de son etablissement"
        Gate::define('direct_ens', function (User $user, $id) {

            $ens = Enseignant::find($id);
            $direct=Directeur::where('user_id', $user->id)->first();
            if ($ens && $direct && $ens->etablissement_id == $direct->etablissement_id && $user->role==1) {
                return true;
            }

            return false;
        });

        //check if "admin_etab" can show "enseignant de son etablissement"
        Gate::define('admin_ens', function (User $user, $id) {
            $ens = Enseignant::find($id);
            $admin = Administrateur::where('user_id', $user->id)->first();


            if($ens && $admin &&$ens->etablissement_id == $admin->etablissement_id && $user->role==2){

                return true;
            }

        });

        ///////////////////// IN ETABLISSEMENT CONTROLLER  ///////////

        //check if directeur_etab or admin_etab can show his etablissement : 
        Gate::define('direct_etab', function (User $user, $id) {

            $admin = Administrateur::where('user_id', $user->id)->first();

            $direct=Directeur::where('user_id', $user->id)->first();

            if($direct && $user->role==1 && $direct->etablissement_id==$id){
                return true;
            }
            if($admin && $user->role==2 && $admin->etablissement_id==$id){
                return true;}

       return false; 

        });

         ///////////////////// IN INTERVENTIONS CONTROLLER  ///////////
         Gate::define('interv_etab', function (User $user, $id) {

            $admin = Administrateur::where('user_id', $user->id)->first();
            $inter = Intervention::find($id);
           if($admin && $user->role==2 && $admin->etablissement_id==$inter->etablissement_id){
            return true;
       }
       return false;


        });





}
}
