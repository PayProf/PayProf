<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInterventionRequest;
use App\Http\Requests\UpdateInterventionRequest;
use App\Http\Resources\InterventionResource;
use App\Http\Resources\InterventionShowMoreResource;
use App\Models\Intervention;
use Illuminate\Support\Facades\DB;
use App\Traits\HttpResponses;

class InterventionController extends Controller
{
    // A class that handles the success and error messages
    use HttpResponses;
   
   
//=========================================The access is retricted for:AdminUAE||President ================================================
   
 
    /**
     * Indexe() it's a methode that serve to display all the directors with there etablissement.
     * I used in this method DirecteurResource that serve to filter the data .
     * @return mixed the important data of all directeurs such as :(Nom|prenom|etablissement......) .
    */

    public function index()
            {    //return Intervention ::all();
                 return  InterventionResource::collection(Intervention::with('enseignant','etablissement')->latest()->paginate(5));
            }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInterventionRequest $request)
            {
                //  $intervention=new InterventionResource(Intervention::create($request->all()));
                 
                 
                //  if($intervention)
                 
                //  {
                //     return response()->json(["message"=>"added successfuly"]);
                //  }
                        $intervention=new Intervention();
                        $enseignant=$intervention->IdEnseignant($request['PPR']);
                        $etablissement=       //auth()->user()->administrateur->etablissement_id;
                        $intervention-> intitule_intervention= $request['IntituleIntervention'];
                        $intervention-> annee_univ= $request['AnneeUniv'];
                        $intervention-> semestre= $request['Semestre'];
                        $intervention-> date_debut= $request['DateDebut'];
                        $intervention->Nbr_heures= $request['NbrHeures'];
                        $intervention->date_fin= $request['DateFin'];
                        $intervention->enseignant_id=$enseignant ;
                        $intervention->etablissement_id= $etablissement ;

                        $intervention->save();
                       
                        return $this->succes("","Intervention added successfully");

                
            }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
              return new InterventionResource(Intervention::with('enseignant','etablissement')->findOrFail($id));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInterventionRequest $request, $id)

  
    {                 $intervention=Intervention::FindOrFail($id);
                    
                     
                     $enseignant=$intervention->IdEnseignant($request['PPR']);
                     // $etablissement= 1; //auth()->user()->administrateur->etablissement_id;
                   
                      $intervention->intitule_intervention=$request['IntituleIntervention'];
                      $intervention->annee_univ = $request['AnneeUniv'] ;
                      $intervention->semestre = $request['Semestre'];
                      $intervention->date_debut = $request['DateDebut'] ;
                      $intervention->date_fin = $request['DateFin'] ;
                      $intervention->Nbr_heures = $request['NbrHeures'] ;
                      $intervention->enseignant_id=$enseignant;
                      //$intervention->etablissement_id=$etablissement;
          
                      $intervention->save();
                      

                      return $this->succes("","Intervention updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $intervention= Intervention::find($id);
     
       if($intervention)
       {
        $intervention->delete();
        return $this->succes("","intervention deleted successfully");
       }

    }

    public function ShowMore($id)
    {    // the goal of the this function it's to give a nice appearance of the interventions 
        //because we can't display all the fields in a table so i suggest to create like interface where we can display all the details of the intervention 
             return new InterventionShowMoreResource(Intervention::with('enseignant','etablissement')->find($id));
    }

    public function activeVisaUae(UpdateInterventionRequest $request,$id)
    {
           //  intervention::find($id)->update($request->all());
           $intervention =Intervention::find($id);
           $intervention->visa_uae=$request['VisaUae'];
           $intervention->save();
              
    }

        public function activeVisaEtab(UpdateInterventionRequest $request,$id)
    {
             //intervention::find($id)->update($request->all());
             $intervention =Intervention::find($id);
             $intervention->visa_etab=$request['VisaEtab'];
             $intervention->save();

    }


        public function ShowMyEtabInterventions()
        
        {  
              $etab_id=1; //auth()->user()->administrateur->etablissement_id;
             return  InterventionResource::collection(Intervention::where('etablissement_id',$etab_id)->with('enseignant','etablissement')->latest()->paginate(5));
           


        }


       public function EnseignantInterventions($id)
       {

        return  InterventionResource::collection(Intervention::where('enseignant_id',$id)->with('enseignant','etablissement')->latest()->paginate(5));

       }


}   
