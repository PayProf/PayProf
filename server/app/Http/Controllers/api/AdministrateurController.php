<?php

namespace App\Http\Controllers\api;

use App\Events\storeuser;
use App\Events\store_user;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdministrateurRequest;
use App\Http\Requests\UpdateAdministrateurRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Resources\AdministrateurResource;
use App\Http\Resources\EtablissementResource;
use App\Models\Administrateur;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Resources\DirecteurResource;
use App\Models\Directeur;

class AdministrateurController extends Controller
{
    use HttpResponses;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('check_role', [4])) {
            // Retrieve a paginated list of Administrateur objects
            $admin = Administrateur::latest()->paginate(10);

            // Transform the Administrateur objects into JSON resources
            $data = AdministrateurResource::collection($admin);

            // Return a success response with the transformed data

            return $this->succes($data, 'DISPLAY');
        }


        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdministrateurRequest $request)
    {

        if (Gate::allows('check_role', [4])) {
            // Create a new Administrateur object based on the request data
            $admin = new Administrateur();
            $admin->PPR = $request->input('PPR');
            $admin->nom = $request->input('nom');
            $admin->prenom = $request->input('prenom');
            $admin->etablissement_id = $admin->getIdEtablissement($request['Grade']);
            $admin->email_perso = $request->input('email_perso');


            $admin->save();
            $id = event(new storeuser($request->input('email_perso'), 1, $request->input('nom'), $request->input('prenom')));
            $admin->user_id = $id[0];
            $admin->save();
            $data = new AdministrateurResource(Administrateur::find($admin->id));


            // Check if the creation was successful and return the appropriate response
            if ($data) {
                return $this->succes("", "SUCCESSFULLY ADDED");
            } else {
                return $this->error("", "UNSUCCESSFULLY ADDED", 500);
            }
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::allows('check_role', [4]) || Gate::allows('can_admin', $id)) {
            // Retrieve the specific Administrateur resource by ID
            $data = new AdministrateurResource(Administrateur::findOrFail($id));

            // Return a success response with the transformed data
            return $this->succes($data, 'DISPLAY');
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdministrateurRequest $request, $id)
    {
        //only admiuae
        if (Gate::allows('check_role', [4])) {
            // Find the existing Administrateur resource by ID
            $admin = Administrateur::findOrFail($id);

            // Update the Administrateur resource with the request data
            $value = $admin->update($request->all());

            // Check if the update was successful and return the appropriate response
            if ($value) {
                $data = new AdministrateurResource(Administrateur::find($id));
                return $this->succes($data, 'SUCCESSFULLY UPDATED');
            }

            return $this->error('', 'UNSUCCESSFULLY UPDATED', 500);
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('check_role', [4])) {
            // Find the existing Administrateur resource by ID
            $admin = Administrateur::find($id);

            // Delete the Administrateur resource
            $admin->delete();

            // Return a success response
            return $this->succes('', 'SUCCESSFULLY DELETED');
        }
        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    public function ShowMyprofile($user_id)
    {

        if (Gate::allows('check_role', [4]) || Gate::allows('admin_modify', $user_id)) {


            // Retrieve the Administrateur resource based on the user_id
            $admin = Administrateur::where('user_id', $user_id)->first();

            // Check if the Administrateur resource exists and return the appropriate response
            if ($admin) {
                $data = new AdministrateurResource($admin);
                return $this->succes($data, 'PROFILE');
            } else {
                return $this->error("", "unavailable id", 500);
            }
        }


        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    public function Updateemail(UpdateEmailRequest $request, $user_id)
    {
        //seulement
        if (Gate::allows('check_role', [4]) || Gate::allows('admin_modify', $user_id)) {

            // Retrieve the Administrateur resource based on the user_id
            $admin = Administrateur::where('user_id', $user_id)->first();

            // Update the email_perso attribute with the provided email_perso value
            $admin->email_perso = $request->input('email_perso');
            $admin->save();

            // Return a success response
            return $this->succes('', 'SUCCESSLY CHANGED');
        }

        return $this->error('', 'ACCES INTERDIT ', 403);
    }

    public function AllEnseignants($user_id)
    {

        if (Gate::allows('check_role', [2]) || Gate::allows('admin_modify', $user_id)) {


            $user = Administrateur::where('user_id', $user_id)->first();
            if ($user) {
                $etablissement_id = $user->etablissement_id;
                $data = Enseignant::where('etablissement_id', $etablissement_id)->with('grade')->latest()->paginate(5);
                if ($data) {
                    return $this->succes($data, "DISPLAY");
                } else {
                    return $this->error("", "NO DATA FOUND", 404);
                }
            }

            return $this->error('', 'ACCES INTERDIT ', 403);
        }
    }

    public function MyDir()
    {
        $id=auth()->user()->administrateur->etablissement_id;
        return new DirecteurResource(Directeur::where('etablissement_id', $id)->with('etablissement')->first());
    }
}
