<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtablissementRequest;
use App\Http\Requests\UpdateEtablissementRequest;
use App\Http\Resources\EtablissementResource;
use App\Models\Administrateur;
use App\Models\Directeur;
use App\Models\Enseignant;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Gate;



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
        if (Gate::allows('check_role', [4, 3])) {

            //// Retrieve a paginated list of Etablissement objects.
            $etablissements = Etablissement::latest()->paginate(10);
            // used to transform the collection of Etablissement objects into a collection of JSON resources.
            $data = EtablissementResource::collection($etablissements);
            // Return a success response with the transformed data.
            return $this->succes($data, 'DISPLAY');
        }

        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEtablissementRequest $request)
    {
        if (Gate::allows('check_role', [4])) {

            // Create a new Etablissement object based on the request data.
            $data = new EtablissementResource(Etablissement::create($request->all()));
            // Return a success response with the transformed data.
            return $this->succes($data, 'SUCCESSFLY INSERT');
        }

        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (Gate::allows('check_role', [4, 3]) || Gate::allows('direct_etab', $id)) {

            // Retrieve the specific Etablissement resource by ID.
            $data = new EtablissementResource(Etablissement::findOrFail($id)); //returns a specific Etablissement resource by ID 
            // Check if the 'with' query parameter is present in the request.
            if ($request->query('with')) {
                $value = $request->query('with');
                $array = ['Enseignants', 'Administrateur', 'Interventions'];
                // Check if the 'with' value is one of the allowed relationships.
                if (in_array($value, $array)) {
                    // Load the specified relationship for the Etablissement
                    $data = new EtablissementResource(Etablissement::find($id)->loadMissing($value));
                } else {
                    // Return an error response if the specified relationship is not found.
                    return $this->error('', 'the fild that you enter is not found', 400);
                }
            }
            // Return a success response with the transformed data.
            return $this->succes($data, 'DISPLAY');
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
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
        if (Gate::allows('check_role', [4])) {
            // Find the existing Etablissement resource by ID.
            $etablissment = Etablissement::find($id);
            // Update the Etablissement resource with the request data.
            $etablissment->update($request->all());
            // Retrieve the updated Etablissement resource.
            $data = new EtablissementResource(Etablissement::find($id));
            if ($data) {
                return $this->succes($data, 'DISPLAY');
            } else {
                return $this->error("", 'NO DATA FOUND', 402);
            }
        }
        return $this->error('', 'acces interdit ', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('check_role', [4])) {

            // Find the existing Etablissement resource by ID.
            $etablissement = Etablissement::find($id);
            //This method deletes a specific Etablissement resource by ID.
            if ($etablissement) {
                $etablissement->delete();
                //returns a JSON response indicating success .

                $data = new EtablissementResource(Etablissement::find($id));
                return $this->succes('', 'SUCCESSFULLY DELETED');
            } else {
                return $this->error('', 'not found ', 403);
            }
        }
        return $this->error('', 'acces interdit ', 500);
    }

    public function ShowMyetablissement($user_id)
    {

        // Check the role value to determine the user type and
        // retrieve the associated Etablissement.
        if (auth()->user()->role == 0 &&  auth()->user()->id == $user_id) {

            $data = Enseignant::where('user_id', $user_id)->first();
            $enseignant = ['id_etablissement' => $data->etablissement_id];
            $etablissement = Etablissement::where('id', $enseignant['id_etablissement'])->first();
            return $this->succes($etablissement, "MY ETABLISSEMENT");
        }
        if (auth()->user()->role == 2 &&  auth()->user()->id == $user_id) {

            $data = Administrateur::where('user_id', $user_id)->first();
            $admin = ['id_etablissement' => $data->etablissement_id];
            $etablissement = Etablissement::where('id', $admin['id_etablissement'])->first();
            return $this->succes($etablissement, "MY ETABLISSEMENT");
        }
        if (auth()->user()->role == 1 &&  auth()->user()->id == $user_id) {

            $data = Directeur::where('user_id', $user_id)->first();
            $directeur = ['id_etablissement' => $data->etablissement_id];
            $etablissement = Etablissement::where('id', $directeur['id_etablissement'])->first();
            return $this->succes($etablissement, "MY ETABLISSEMENT");
        }
    }
}
