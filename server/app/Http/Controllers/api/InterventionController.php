<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInterventionRequest;
use App\Http\Requests\UpdateInterventionRequest;
use App\Http\Resources\InterventionResource;
use App\Http\Resources\InterventionShowMoreResource;

use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
                      $enseignant = DB::table('enseignants')
                      ->select('id')
                      ->where('PPR', $request['PPR'])
                      ->first();
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

                
            }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
              return new InterventionResource(Intervention::with('enseignant','etablissement')->find($id));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
  
    {
        

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
        return response()->json(["message"=>"deleted successfuly"]);
       }

    }

    public function ShowMore($id)
    {    // the goal of the this function it's to give a nice appearance of the interventions 
        //because we can't display all the fields in a table so i suggest to create like interface where we can display all the details of the intervention 
             return new InterventionShowMoreResource(Intervention::with('enseignant','etablissement')->find($id));
    }

    public function activeVisaUae(UpdateInterventionRequest $request,$id)
    {
             intervention::find($id)->update($request->all());

    }

        public function activeVisaEtab(UpdateInterventionRequest $request,$id)
    {
             intervention::find($id)->update($request->all());

    }
}