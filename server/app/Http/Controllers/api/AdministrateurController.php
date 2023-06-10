<?php

namespace App\Http\Controllers\api;

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
use Illuminate\Http\Request;

class AdministrateurController extends Controller
{
    use HttpResponses;
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
        // Retrieve a paginated list of Administrateur objects
        $admin = Administrateur::latest()->paginate(10);

        // Transform the Administrateur objects into JSON resources
        $data = AdministrateurResource::collection($admin);

        // Return a success response with the transformed data
        return $this->succes($data, 'DISPLAY');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdministrateurRequest $request)
    {
        $email=$request->email_perso;
                  $role=2;
                  $nom=$request->nom;
                  $prenom=$request->prenom;
                  $id_user=   $this->destinationController->register($email,$role,$nom,$prenom);
        // Create a new Administrateur object based on the request data
        $admin=new Administrateur();
        $admin->PPR=$request->input('PPR');
        $admin->nom=$request->input('nom');
        $admin->prenom=$request->input('prenom');
        $admin->etablissement_id=$request->input('etablissement_id');
        $admin->email_perso=$request->input('email_perso');
        $admin->user_id=$id_user;
        $admin->save();
        $data=new AdministrateurResource(Administrateur::find($request->id));
    
   
        // Check if the creation was successful and return the appropriate response
        if ($data) {
            return $this->succes("", "SUCCESSFULLY ADDED");
        } else {
            return $this->error("", "UNSUCCESSFULLY ADDED", 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve the specific Administrateur resource by ID
        $data = new AdministrateurResource(Administrateur::findOrFail($id));

        // Return a success response with the transformed data
        return $this->succes($data, 'DISPLAY');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdministrateurRequest $request, $id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the existing Administrateur resource by ID
        $grade = Administrateur::findOrFail($id);

        // Delete the Administrateur resource
        $grade->delete();

        // Return a success response
        return $this->succes('', 'SUCCESSFULLY DELETED');
    }

    public function Show_Myprofile($user_id)
    {
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

    public function Update_email(UpdateEmailRequest $request, $user_id)
    {
        // Retrieve the Administrateur resource based on the user_id
        $admin = Administrateur::where('user_id', $user_id)->first();

        // Update the email_perso attribute with the provided email_perso value
        $admin->email_perso = $request->input('email_perso');
        $admin->save();

        // Return a success response
        return $this->succes('', 'SUCCESSLY CHANGED');
    }
    public function All_Enseignants($user_id){
        $user=Administrateur::where('user_id', $user_id)->first();
        if($user){
            $etablissement_id=$user->etablissement_id;
            $data = new EtablissementResource(Etablissement::findOrFail($etablissement_id)->loadMissing('Enseignants')->latest()->paginate(10));
            if($data){
               return $this->succes($data,"DISPLAY");
            }else{
                return $this->error("","NO DATA FOUND",404);
            }
        }else{
            return $this->error("","NO DATA FOUND",404);
    }
}
}
