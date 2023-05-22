<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\AuthController;
use App\Http\Resources\EnseignantResource;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnseignantRequest;
use App\Http\Requests\UpdateEnseignantRequest;
use App\Http\Resources\EnseignantInterventionResource;
use App\Models\Enseignant;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
class EnseignantController extends Controller
{
      protected $destinationController;

      public function __construct(AuthController $destinationController)
      {
          $this->destinationController = $destinationController;
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
                {
                  $email="damism6665@gmail.com";
                  $role=4;
                  $this->destinationController->register($email,$role);
                                //return Enseignant::with('etablissement','grade')->paginate(5);// display all the columns

                                return EnseignantResource::collection(Enseignant::all()); 
                                //display just the main columns such as Nom|prenom|PPR|date_naissance|etab|Garad|etab_id|grade_id/user_role
                                 //  by using the class resource that give this privileges
                               

                }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(request $request)

      {  
                  
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function show($id)
                {
                                
                                // display  the main  columns of Enseignant 
                                
                                return new EnseignantResource(Enseignant::with('etablissement','grade','user')->find($id));
                                
                                // display all the columns of enseignant 
                                        
                                //$ens= Enseignant::with('grade','etablissement')->where('id',$id)->get();
                               //return response()->json($ens);
                }
        
     

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function update( UpdateEnseignantRequest $request, $id)
                {   
                
                                //the class UpdateEnseignantRequest handles both PUT and Patch Request(for more details check the class  ) 
                                 Enseignant::find($id)->update($request->all());


                              
                }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
                public function destroy($id)
                { 
                                // findorfail send a error msg in case of the entry of invalid id
                                $ens= Enseignant::FindOrfail($id);
                        
                                $ens->delete();
                        
                                // success msg 
                                return response()->json(["message"=>"Enseignant deleted successfuly"]);
                
                }

                public function ShowMyInterventions($id)

                {                //I think this methods will make the process or the tasks much more easier to the manager of security 
                                //$ensint=Enseignant::with('interventions.etablissement')->find($id);
                                //return response()->json($ensint);
                
                                //this method display all the interventions of a specified prof
                               return new EnseignantInterventionResource(Enseignant::with('interventions.etablissement')->find($id));
                                
                        
                }

                public function ShowMyPayments($id)
                {
                      $ens=  Enseignant::with('paiements')->find($id);
                      return response()->json($ens);

                }
   
}
