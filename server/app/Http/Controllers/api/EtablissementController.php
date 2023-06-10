<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkStorerequest;
use App\Http\Requests\StoreEtablissementRequest;
use App\Http\Requests\UpdateEtablissementRequest;
use App\Http\Resources\EtablissementResource;
use App\Models\Administrateur;
use App\Models\Enseignant;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;



class EtablissementController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //// Retrieve a paginated list of Etablissement objects.
        $etablissements = Etablissement::latest()->paginate(10);  
         // used to transform the collection of Etablissement objects into a collection of JSON resources.
        $data = EtablissementResource::collection($etablissements);
        // Return a success response with the transformed data.
        return $this->succes($data, 'DISPLAY');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEtablissementRequest $request)
    {
        // Create a new Etablissement object based on the request data.
        $data = new EtablissementResource(Etablissement::create($request->all()));  
        // Return a success response with the transformed data.
        return $this->succes($data, 'SUCCESSFLY INSERT');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Retrieve the specific Etablissement resource by ID.
        $data = new EtablissementResource(Etablissement::findOrFail($id)); //returns a specific Etablissement resource by ID 
       // Check if the 'with' query parameter is present in the request.
        if ($request->query('with')) {
            $value = $request->query('with');
            $array = ['Enseignants', 'Administrateur', 'Interventions'];
            // Check if the 'with' value is one of the allowed relationships.
            if (in_array($value, $array)) {
                // Load the specified relationship for the Etablissement
                $data = new EtablissementResource(Etablissement::findOrFail($id)->loadMissing($value)->latest()->paginate(10));
            } else {
                 // Return an error response if the specified relationship is not found.
                return $this->error('', 'the fild that you enter is not found', 400);
            }
        }
        // Return a success response with the transformed data.
        return $this->succes($data, 'DISPLAY');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEtablissementRequest $request, $id)
    {
         // Find the existing Etablissement resource by ID.
        $etablissment = Etablissement::findOrFail($id);
        // Update the Etablissement resource with the request data.
        $etablissment->update($request->all()); 
       // Retrieve the updated Etablissement resource.
        $data = new EtablissementResource(Etablissement::find($id)); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the existing Etablissement resource by ID.
        $etablissement = Etablissement::findOrFail($id);
         //This method deletes a specific Etablissement resource by ID.
        $etablissement->delete();
         //returns a JSON response indicating success .
        return $this->succes('', 'DELETED DATA');
    }
    public function Show_Myetablissement($user_id, $role)
    {
        // Check the role value to determine the user type and
        // retrieve the associated Etablissement.
        if ($role == 4) {
            $data = Enseignant::where('user_id', $user_id)->first();
            $enseignant = ['id_etablissement' => $data->etablissement_id];
            $etablissement = Etablissement::where('id', $enseignant['id_etablissement'])->first();
            return $this->succes($etablissement, "MY ETABLISSEMENT");
        }
        if ($role == 1) {
            $data = Administrateur::where('user_id', $user_id)->first();
            $admin = ['id_etablissement' => $data->etablissement_id];
            $etablissement = Etablissement::where('id', $admin['id_etablissement'])->first();
            return $this->succes($etablissement, "MY ETABLISSEMENT");
        }
        if ($role == 2) {
            $data = Directeur::where('user_id', $user_id)->first();
            $directeur = ['id_etablissement' => $data->etablissement_id];
            $etablissement = Etablissement::where('id', $directeur['id_etablissement'])->first();
            return $this->succes($etablissement, "MY ETABLISSEMENT");
        }
    }
}
