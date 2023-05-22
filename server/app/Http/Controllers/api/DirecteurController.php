<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDirecteurRequest;
use App\Http\Requests\UpdateDirecteurRequest;

use App\Http\Resources\DirecteurResource;
use App\Models\Directeur;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
class DirecteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HttpResponses;
    public function index()
    {
        return DirecteurResource::collection(Directeur::with('etablissement')->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirecteurRequest $request)
    {
           $directeur=new Directeur();
            $request['IdEtablissement']=1;// auth()->user()->administrateur->etablissement_id
           $directeur->PPR = $request['PPR'];
           $directeur->nom = $request['nom'];
           $directeur->prenom = $request['prenom'];
           $directeur->date_naissance = $request['DateNaissance'];
           $directeur->etablissement_id = $request['IdEtablissement'];
        //$directeur->user_id = $request['IdUser'];
           $directeur->email_perso=$request['email_perso'];
           $directeur->save();
            return $this->succes("","added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
             return new DirecteurResource(Directeur::with('etablissement')->FindOrFail($id));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirecteurRequest $request, $id)
    {    

       $directeur=Directeur::find($id);
       $directeur->PPR = $request['PPR'];
       $directeur->nom = $request['nom'];
       $directeur->prenom = $request['prenom'];
       $directeur->date_naissance = $request['DateNaissance'];
       $directeur->email_perso=$request['email_perso'];
       $directeur->save();
       return $this->succes("","updated successfully");
       
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
             $directeur=Directeur::FindOrfail($id);
             
             $directeur->delete();

             unlink(public_path('uploads').'/'.$directeur->image);
             
             return $this->succes("","Directeur deleted successfully");
    }

/*===================================================================================================================*/

    public function UpdateMyEmail( UpdateDirecteurRequest $request ,$id)
                {

                            $directeur=Directeur::where('user_id',$id)->first();
                            
                            $directeur->email_perso=$request['email_perso'];
                            
                            $directeur->save();
                            
                            return $this->succes("","email updated successfully");

                }



    public function ShowMyProfil($id)
               {
                        return new DirecteurResource(Directeur::where('user_id',$id)->with('etablissement')->first());
               }
    

    public function UploadMyImage( Request $request,$id)
               {

                         $request->validate(
                              [
                                   'image'=>'required|max:1024|mimes:png,jpg,png'
                                  
                               ]
                              );


                            $directeur=Directeur::where('user_id',$id)->first();
                            if($request->hasFile('image'))
                         { 
                              $file=$request->image;
                              $image_name=time().'_'. $file->getClientOriginalName();
                              $file->move(public_path('uploads'),$image_name);
                             
                             
                              if($directeur->image)
                         {
                              unlink(public_path('uploads'). '/' .$directeur->image);
                         }
                              
                              $directeur->image=$image_name;
                              $result=$directeur->save();
                         }
                              
                         if($result)
                         {
                              return $this->succes("","image uploaded successfully");    
                         }
 
                   
               }           



}
