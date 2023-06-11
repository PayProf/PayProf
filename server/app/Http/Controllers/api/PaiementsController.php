<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaiementsRequest;
use App\Http\Requests\UpdatePaiementsRequest;
use App\Http\Resources\PaiementResource;
use App\Models\Paiements;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class PaiementsController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('check_role', [3,0])) {   
        // Retrieve a paginated list of Paiements objects
        $paiement = Paiements::latest()->paginate(10);

        // Transform the Paiements objects into JSON resources
        $data = PaiementResource::collection($paiement);

        // Return a success response with the transformed data
        return $this->succes($data, 'DISPLAY');
        }
        return $this->error('','ACCES INTERDIT ',403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaiementsRequest $request)
    {
       //TRIGGER

        // Create a new Paiements object based on the request data
        // $data = new PaiementResource(Paiements::create($request->all()));

        // Return a success response with the created resource
        // return $this->succes($data, 'SUCCESSFLY INSERT');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::allows('check_role', [3,0])) {
        // Retrieve the specific Paiements resource by ID
        $data = new PaiementResource(Paiements::findOrFail($id));

        // Return a success response with the transformed data
        return $this->succes($data, 'DISPLAY');
    }

        return $this->error('','ACCES INTERDIT ',403);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaiementsRequest $request, $id)
    {
        // Find the existing Paiements resource by ID
        $paiement = Paiements::findOrFail($id);

        // Update the Paiements resource with the request data
        $paiement->update($request->all());

        // Retrieve the updated resource
        $data = new PaiementResource(Paiements::find($id));

        // Return a success response with the updated resource
        return $this->succes($data, 'SUCCESSFLY UPDATE');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the existing Paiements resource by ID
        $paiement = Paiements::findOrFail($id);

        // Delete the Paiements resource
        $paiement->delete();

        // Return a success response
        return $this->succes('', 'DELETED DATA');
    }

    public function Show_paiements_enseignant($id_enseignant)
    {
        // Retrieve payments (Paiements) for a specific enseignant
        // based on the enseignant_id. The related enseignant
        // model is eager loaded using the with() method to retrieve the associated teacher data.
        $data = Paiements::where('enseignant_id', $id_enseignant)->with('enseignant')->get();

        // Return a success response with the retrieved data
        return $this->succes($data, 'DISPLAY');
    }
}
