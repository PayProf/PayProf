<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInterventionRequest;
use App\Http\Requests\UpdateInterventionRequest;
use App\Http\Resources\InterventionResource;
use App\Http\Resources\InterventionShowMoreResource;
use Illuminate\Support\Facades\DB;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Gate;

class InterventionController extends Controller
{
    // A class that handles the success and error messages
    use HttpResponses;


    //========================================= The access is retricted for:AdminUAE||President ================================================


    /**
     * Indexe() it's a methode that serve to display all the interventions with the name of the etablissement and also name of Enseiganant.
     * I used  InterventionResource class  that serve to filter  data .
     * @return mixed the important data of all interventions.
     */

    public function index()
    {
        if (Gate::allows('check_role', [4, 3])) {
            return  InterventionResource::collection(Intervention::with('enseignant','etablissement')->latest()->paginate(10));
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    //===========================================  The access is retricted for:AdminEtab ==================================================


    /**
     * Store() it's a method that serve to add a new intervention.
     * @param  StoreInterventionrRequest / it's a class that serve to validate the data before the insert.
     * @return  / a success message that mean the new intervention was successfully inserted
     * Attention the comments in this method must be respected
     */

    public function store(StoreInterventionRequest $request)

    {

        if (Gate::allows('check_role', [2])) {
            $intervention = new Intervention();
            $enseignant = $intervention->IdEnseignant($request['PPR']);
            $etablissement = auth()->user()->administrateur->etablissement_id;
            $intervention->intitule_intervention = $request['IntituleIntervention'];
            $intervention->annee_univ = $request['AnneeUniv'];
            $intervention->semestre = $request['Semestre'];
            $intervention->date_debut = $request['DateDebut'];
            $intervention->Nbr_heures = $request['NbrHeures'];
            $intervention->date_fin = $request['DateFin'];
            $intervention->enseignant_id = $enseignant;
            $intervention->etablissement_id = $etablissement;
            $intervention->save();
            return $this->succes("", "Intervention added successfully");
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    //============================================= The access is retricted for:AdminUAE||President =======================================================



    /**
     * Show() this method serve to display a specified intervention .
     * @param  int  $id it's ID Intervention!!!!!!
     * @return   // error message in case of invalid InterventionrId
     */

    public function show($id)

    {
        if (Gate::allows('check_role', [4, 3]) || Gate::allows('interv_etab', $id)) {
            return new InterventionResource(Intervention::with('enseignant', 'etablissement')->findOrFail($id));
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }


    //=================================================== The access is retricted for:AdminEtab ==========================================================


    /**
     * Update() this method serve to update the information of a specified intervention.
     * @param  UpdateInterventionRequest contain the validation rules of the data .
     * @param  int  $id ID intervention !!!!!!!!!!!
     * @return  //a success message that mean the data of theintervention  was successfully updated.
     */

       public function update(UpdateInterventionRequest $request, $id)


          { //admin_etab si meme etab
                    if (Gate::allows('interv_etab', $id)) {
                 $intervention=Intervention::FindOrFail($id);
//                 $enseignant=$intervention->IdEnseignant($request['PPR']);                                //it's a method that return the id of the enseignant
//                 $intervention->intitule_intervention=$request['IntituleIntervention'];
//                 $intervention->annee_univ = $request['AnneeUniv'] ;
//                 $intervention->semestre = $request['Semestre'];
//                 $intervention->date_debut = $request['DateDebut'] ;
//                 $intervention->date_fin = $request['DateFin'] ;
//                 $intervention->Nbr_heures = $request['NbrHeures'] ;
//                 $intervention->enseignant_id=$enseignant;
                 //$intervention->etablissement_id=$etablissement;                                        // we will not use it because when he update the etablissement_id remain the same
                 //$intervention->save();
                        $data=$intervention->update($request->all());
                        if($data){
                            return $this->succes("","Intervention updated successfully");
                        }else{
                            return $this->error("","error",403);
                        }

              }
              return $this->error('','ACCES INTERDIT ',403);
          }



    //==================================================== The access is retricted for:AdminEtab =================================================================


    /**
     * Destroy() this method serve to remove a specified intervention.
     * @param  int  $id ID Intervention !!!!!!
     * @return ///a success message that means the directeur was successfully deleted.
     */

    public function destroy($id)

          {
              if (Gate::allows('interv_etab', $id)) {
                 $intervention= Intervention::find($id);
                 if($intervention)
                 {
                 $intervention->delete();
                 return $this->succes("","intervention deleted successfully");
                 }
                else{
                     return $this->error("","intervention introuvable",404);
                 }
              }
              return $this->error('','ACCES INTERDIT ',403);


          }



    //============================================= The access is retricted for:AdminEtab|President|directeur|AdminUAE  ===============================



    /**
     * ShowMore this method serve to display more information about a specified intervention.
     * the goal of the this function it's to give a nice appearance of the interventions because we can't display all the fields in a table
     * so i suggest to create like interface where we can display all the details of an intervention
     * @param  int  $id ID Intervention !!!!!!
     */


    public function ShowMore($id)

    {

        if (Gate::allows('check_role', [4, 3]) || Gate::allows('interv_etab', $id)) {

            if (Intervention::where('id', $id)->exists()) {
                return new InterventionShowMoreResource(Intervention::with('enseignant', 'etablissement')->find($id));
            } else {
                return $this->error("", "intervention introuvable", 404);
            }
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }



    //=============================================  The access is retricted for : President  ===============================================================



    /**
     * activeVisaUae this method serve to active the visaUae of a specified intervention.
     * @param UpdateInterventionRequest  contain the validation rules of the data .
     * @param  int  $id ID Intervention !!!!!!
     */


    public function activeVisaUae(UpdateInterventionRequest $request, $id)
    {
        if (Gate::allows('check_role', [3])) {
            $intervention = Intervention::find($id);
            $intervention->visa_uae = $request['VisaUae'];
            $intervention->save();
            return $this->succes("", "updated successfully");
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }


    //================================================== The access is retricted for : DirecteurEtab  =========================================


    /**
     *activeVisaUae this method serve to active the visaEtab of a specified intervention.
     *@param UpdateInterventionRequest  contain the validation rules of the data .
     * @param  int  $id ID Intervention !!!!!!
     */


    public function activeVisaEtab(UpdateInterventionRequest $request, $id)
    {
        if (Gate::allows('check_role', [1])) {
            $intervention = Intervention::find($id);
            $intervention->visa_etab = $request['VisaEtab'];
            $intervention->save();
            return $this->succes("", "updated successfully");
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }




    //=========================================  The access is retricted for : DirecteurEtab|AdminEtab   ===================================================================

    /**
     * ShowMyEtabInterventions  this method serve to display the interventions of the Admin Eatblissement Or Directeur Etablissement.

     * the comments should be respected and approved by the security developper

     */



    public function ShowMyEtabInterventions()

    {
        if (Gate::allows('check_role', [1, 2])) {

            $role = auth()->user()->role;
            if ($role == 2) {
                $etab_id = auth()->user()->administrateur->etablissement_id;
            } elseif ($role == 1) {
                $etab_id = auth()->user()->directeur->etablissement_id;
            }

            return  Intervention::where('etablissement_id', $etab_id)->with('enseignant', 'etablissement')->latest()->paginate(5);
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    //========================================================  The access is retricted for : DirecteurEtab|AdminEtab|President|AdminUAE    =================================================================

    /**
     * EnseignantInterventions this method serve to display the interventions of a specified enseignant.
     * @param $id Id Enseignant !!!!!!!!
     */




       public function EnseignantInterventions($id)
          {


//                 if(Intervention::where('enseignant_id',$id)->exists())
//                 {
                     return  InterventionResource::collection(Intervention::where('enseignant_id',$id)->with('enseignant','etablissement')->latest()->paginate(5));
//                 }
//
//                 else
//                {
//                     return $this->error("","intervention introuvable",404);
//                }



          }
    public function EnseignantInterventionsGraphe($id)
    {


//                 if(Intervention::where('enseignant_id',$id)->exists())
//                 {
        return  InterventionResource::collection(Intervention::where('enseignant_id',$id)->with('enseignant','etablissement')->get());
//                 }
//
//                 else
//                {
//                     return $this->error("","intervention introuvable",404);
//                }



    }




    //================================================ SMEH LINA A KHOYA REDA SBER M3ANA ==========================================




    // ======================================================= YOUSSEF HARRAK ===========================================
}
