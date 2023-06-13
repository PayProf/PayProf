<?php

namespace App\Http\Controllers\api;
use App\Events\storeuser;
use App\Http\Controllers\AuthController;
use App\Http\Resources\EnseignantResource;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnseignantRequest;
use App\Http\Requests\UpdateEnseignantRequest;
use App\Http\Resources\EnseignantInterventionResource;
use App\Http\Resources\EnseignantPaymentsResource;
use App\Models\Enseignant;
use App\Models\Intervention;
use App\Models\Paiements;
use App\Traits\HttpResponses;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EnseignantController extends Controller
{

     // A class that handles the success and error messages
     use HttpResponses;
//=========================================================== The access is retricted for:AdminUae|President ==============================================



     /**
     * Index() it's a methode that serve to display all the profs with there etablissement and grade.
     * I used in this method EnseignantResource that serve to filter the data .
     * @return mixed the important data of all PROFS such as :(Nom|prenom|etablissement|grade.......) .
    */

       public function index()

         {   
            if (Gate::allows('check_role', [4,3])) { 

           return EnseignantResource::collection(Enseignant::with('etablissement','grade')->latest()->paginate(10)); 
           
         }
            return $this->error('','ACCES INTERDIT ',403);                    
         }


//============================================================== The access is retricted for:AdminUEtab ========================================================


     /**
     * Store() it's a method that serve to add a new enseignant.
     * @param StoreEnseignantRequest / it's a class that serve to validate the data before the insert.
     * @return / a success message that mean the new enseignant was successfully inserted.
     * Attention the comments in this method must be respected.
     */

       public function store(StoreEnseignantRequest $request)

          {
              
              if (Gate::allows('check_role', [2])) { 

                 $enseignant=new Enseignant();

                 $grade_id=$enseignant->IdGrade($request['Grade']);                                  //IdGrade() it's a method that return the id of the grade
                    
                 $enseignant->PPR = $request['PPR'];
                 $enseignant->nom = $request['nom'];
                 $enseignant->prenom = $request['prenom'];
                 $enseignant->date_naissance = $request['DateNaissance'];
                 $enseignant->etablissement_id = auth()->user()->administrateur->etablissement_id  ;
                 $enseignant->grade_id =$grade_id;

                 $enseignant->email_perso=$request['email_perso'];
                 $enseignant->save();

                 $id=event (new storeuser($request->input('email_perso'),0,$request->input('nom'),$request->input('prenom')));
                 $enseignant->user_id = $id[0];
                 $enseignant->save();


                 return $this->succes("","added successfully");
               }
                 return $this->error('','ACCES INTERDIT ',403);

                 // return new EnseignantResource(Enseignant::create($request->all()));it's another method but we should know the etab_id

          }
//======================================================= The access is retricted for:AdminUEtab|AdminUae|DireteurEtab|President ==================================================

    //the access to this method is restricted for 0,3 and also 1 and 2
     /**
     * Show() this method serve to display a specified teacher with the name and the city of his etablissement and also his  grade  .
     * @param  int  $id it's IDEnseignant!!!!!!
     * @return   // error message in case of invalid enseignantid
     */

       public function show($id)

          {      if (Gate::allows('check_role', [4,3]) || Gate::allows('direct_ens',$id) || Gate::allows('admin_ens',$id) ) {  


                 return new EnseignantResource(Enseignant::with('etablissement','grade')->FindOrFail($id));
                }

                return $this->error('','ACCES INTERDIT ',403);

          }


//=========================================================== The access is retricted for:AdminUEtab ===============================================


     /**
     * Update() this method serve to update the information of a specified enseignant.
     * @param UpdateEnseignantRequest contain the validation rules of the data  //the class UpdateEnseignantRequest handles both PUT and Patch Request(for more details check the class  ) .
     * @param  int  $id ID Enseignant !!!!!!!!
     * @return  //a success message that mean the data of the enseignant was successfully updated.
     */

       public function update( UpdateEnseignantRequest $request, $id)

          {       if ( Gate::allows('admin_ens',$id)) {

                 $enseignant=Enseignant::find($id);
                 $grade_id=$enseignant->IdGrade($request['Grade']);
                 $enseignant->PPR = $request['PPR'];
                 $enseignant->nom = $request['nom'];
                 $enseignant->prenom = $request['prenom'];
                 $enseignant->date_naissance = $request['DateNaissance'];
                 $enseignant->grade_id=$grade_id;

                 $enseignant->save();
                 return $this->succes("","updated successfully");
                }
                 return $this->error('','ACCES INTERDIT ',403);

          }
//======================================= The access is retricted for:AdminEtab ==============================================


     /**
     * Destroy() this method serve to remove a specified enseignant.
     * @param  int  $id ID Enseignant !!!!!!
     * @return ///a success message that mean the enseignant was successfully deleted.
     */

       public function destroy($id)


          {
              if ( Gate::allows('admin_ens',$id) ) {
                 $ens= Enseignant::FindOrfail($id);
                 if($ens->image)
                 unlink(public_path('uploads').'/'.$ens->image);                                         //destroy the appropriate image .       
                 $ens->delete();              
                 return $this->succes("","enseignant deleted successfully");
                }
                 return $this->error('','ACCES INTERDIT ',403);  

          }

//=============================================== The access is retricted for:Enseignant ===========================================================================


     /**
     * ShowMyInterventions() this method serve to display the intervention of the enseignant Who just logged in .
     * @return /// all the interventions of the enseignant Who just logged in
     */



       public function ShowMyInterventions()


          { if (Gate::allows('check_role', [0])) {  
           


              $id=auth()->user()->enseignant->id;

              if(Intervention::where('enseignant_id',$id)->exists())

              {
//                     return  EnseignantInterventionResource::collection (Enseignant::where('id',$id)->with('interventions.etablissement')->paginate(3));
                  return Intervention::where('enseignant_id',$id)->paginate(5);
              }

              else
              {
                     return $this->error("","Pas d'interventions pour le moment",404);
              }
            
            }


            return $this->error('','ACCES INTERDIT ',403);
          
          }

    public function ShowMyGraphe()


    {
        if ( auth()->user()->role==0 ){
        $id=auth()->user()->enseignant->id;
        if(Intervention::where('enseignant_id',$id)->exists())

        {
            return Intervention::where('enseignant_id',$id)->get();
        }

        else
        {
            return $this->error("","Pas d'interventions pour le moment",404);
        }
    }
    return $this->error('','ACCES INTERDIT ',403);
        
    }
//======================================================== The access is retricted for:Enseignant ===================================================


     /**
     * ShowMyPaymentsthis method serve to display the payments of the enseignant Who just logged in .
     * @return /// all the payments of the enseignant Who just logged in
     */

       public function ShowMyPayments()

          {     if (Gate::allows('check_role', [0])) { 
            
               if(auth()->user()->role==0){
                 $id=auth()->user()->enseignant->id;

                 if(Paiements::where('enseignant_id',$id)->exists())

                 {

                     $ens=Enseignant::where('id',$id)->with('paiements')->get();

                     return response()->json($ens);
                 }

                 else
                 {
                     return $this->error("",'Pas de payements pour le moment',404);
                 }
               }
         


               return $this->error('','ACCES INTERDIT ',403);
          }
          return $this->error('','ACCES INTERDIT ',403);
          }



//============================================ The access is retricted for:Enseignant  =====================================================


     /**
     * UploadMyImage this method serve to upload the Profil picture of the enseignant Who just logged inr.

     * @return //success message that mean the picture was successfully uploaded .
     */

       public function UploadMyImage( Request $request)

          {
            if (Gate::allows('check_role', [0])) { 

              $id=auth()->user()->enseignant->id;
             
                 $request->validate([ 'image'=>'required|max:1024|mimes:png,jpg,png' ]);

                 $enseignant=Enseignant::where('id',$id)->first();
                 if($request->hasFile('image'))
                 {
                 $file=$request->image;
                 $image_name=time().'_'. $file->getClientOriginalName();
                 $file->move(public_path('uploads'),$image_name);

// ===================== if the enseignant already has a ProfilPicture =======================================
                 if($enseignant->image)
                 { unlink(public_path('uploads'). '/' .$enseignant->image); }
                 $enseignant->image=$image_name;
                 $result=$enseignant->save();
                 }
// =================================== Si le resultat est true ==============================================
                 if($result)
                 {
                 return $this->succes("","image uploaded successfully");
                 }
               }
         


               return $this->error('','ACCES INTERDIT ',403);
              
              


          }
//==================================== The access is retricted for:Enseignant   ============================================================


     /**
     * ShowMyProfil this method serve to display the informations of the enseignant Who just logged in.
     * @param  int  $id User_id of the Enseignant !!!!!!
     * I used  EnseignantResource class that serve to filter the data .
     */

       public function ShowMyProfil()

          {
            if (Gate::allows('check_role', [0])) { 
              $id=auth()->user()->id;
             
                     return new EnseignantResource(Enseignant::where('user_id',$id)->with('etablissement','grade')->first());
            }
         


           return $this->error('','ACCES INTERDIT ',403);
         }
    
                


//======================================= The access is retricted for:Enseignant =======================================


     /**
     * MyHours this method serve count The hours worked for a specified enseignant .
     */
       public function MyHours ()
          {
            if (Gate::allows('check_role', [0])) { 
              $id=auth()->user()->enseignant->id;

              if(Intervention::where('enseignant_id',$id)->exists())
              {
                 $enseignant=new Enseignant();
                 return response()->json(["hours"=>$enseignant->Hours($id)]);
              }
              else
              {
                     return response()->json(["hours"=>0]);
              }
            }
         


            return $this->error('','ACCES INTERDIT ',403);
              
          }

//==================================== The access is retricted for:Enseignant ============================================


     /**
     * UpdateMyEmail() this method serve to update the email of the enseignant Who just logged in.
     * @param  UpdateEnseignantRequest contain the validation rules of the data .
     * @return //a success message that mean the email of the enseignant was successfully updated.
     */

       public function UpdateMyEmail( UpdateEnseignantRequest $request )

          {
            if (Gate::allows('check_role', [0])) { 

                
                 $id=auth()->user()->enseignant->id;
                 $enseignant=Enseignant::where('id',$id)->first();
                 $enseignant->email_perso=$request['email_perso'];
                 $enseignant->save();
                 return $this->succes("","email updated successfully");
               }
         


               return $this->error('','ACCES INTERDIT ',403);
          
       }


//
}

