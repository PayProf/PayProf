<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\AuthController;
use App\Http\Resources\EnseignantResource;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnseignantRequest;
use App\Http\Requests\UpdateEnseignantRequest;
use App\Http\Resources\EnseignantInterventionResource;
use App\Models\Enseignant;


use App\Traits\HttpResponses;
use Illuminate\Http\Request;

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
                       
                 return EnseignantResource::collection(Enseignant::with('etablissement','grade')->latest()->paginate(10)); 
                                
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

                 $enseignant=new Enseignant();
                 $grade_id=$enseignant->IdGrade($request['Grade']);                                       //IdGrade() it's a method that return the id of the grade 
                 $etablissement_id=1;//auth()->user()->administrateur->etablissement_id                  //the security developper should approuve it
                 $enseignant->PPR = $request['PPR'];
                 $enseignant->nom = $request['nom'];
                 $enseignant->prenom = $request['prenom'];
                 $enseignant->date_naissance = $request['DateNaissance'];
                 $enseignant->etablissement_id = $etablissement_id;
                 $enseignant->grade_id =$grade_id;  //
                 // $enseignant->user_id = $request['IdUser'];                                           // i talked with the postgres admin to add a trigger for this  ;
                 $enseignant->email_perso=$request['email_perso'];
                 $enseignant->save();
                 return $this->succes("","added successfully");
                 // return new EnseignantResource(Enseignant::create($request->all()));it's another method but we should know the etab_id 

          }
//======================================================= The access is retricted for:AdminUEtab|AdminUae|DireteurEtab|President ==================================================
     
    
     /**
     * Show() this method serve to display a specified teacher with the name and the city of his etablissement and also his  grade  .
     * @param  int  $id it's IDEnseignant!!!!!!
     * @return   // error message in case of invalid enseignantid
     */
   
       public function show($id)

          {                                    
                 return new EnseignantResource(Enseignant::with('etablissement','grade')->FindOrFail($id));                    
                 
          }
        
     
//=========================================================== The access is retricted for:AdminUEtab ===============================================


     /**
     * Update() this method serve to update the information of a specified enseignant.
     * @param UpdateEnseignantRequest contain the validation rules of the data  //the class UpdateEnseignantRequest handles both PUT and Patch Request(for more details check the class  ) .
     * @param  int  $id ID Enseignant !!!!!!!!
     * @return  //a success message that mean the data of the enseignant was successfully updated.
     */

       public function update( UpdateEnseignantRequest $request, $id)

          {               
                      
                 $enseignant=Enseignant::find($id);
                 $grade_id=$enseignant->IdGrade($request['Grade']);  
                 $enseignant->PPR = $request['PPR'];
                 $enseignant->nom = $request['nom'];
                 $enseignant->prenom = $request['prenom'];
                 $enseignant->date_naissance = $request['DateNaissance'];
                 $enseignant->grade_id=$grade_id;
                 $enseignant->email_perso=$request['email_perso'];
                 $enseignant->save();
                 return $this->succes("","updated successfully");
                              
          }
//======================================= The access is retricted for:AdminEtab ==============================================


     /**
     * Destroy() this method serve to remove a specified enseignant.
     * @param  int  $id ID Enseignant !!!!!!
     * @return ///a success message that mean the enseignant was successfully deleted. 
     */

       public function destroy($id)

          {                
                 $ens= Enseignant::FindOrfail($id);              
                 unlink(public_path('uploads').'/'.$ens->image);                                         //destroy the appropriate image .       
                 $ens->delete();              
                 return $this->succes("","enseignant deleted successfully");  
          }

//=============================================== The access is retricted for:Enseignant ===========================================================================                
   

     /**
     * ShowMyInterventions() this method serve to display the intervention of the enseignant Who just logged in .
     * @param  int  $id User_id de l'Enseignant !!!!!!
     * @return /// all the interventions of the enseignant Who just logged in  
     */

       public function ShowMyInterventions($id)
          {                
                
                 return  EnseignantInterventionResource::collection (Enseignant::where('user_id',$id)->with('interventions.etablissement')->paginate(10));
                                       
       
          }
//======================================================== The access is retricted for:Enseignant ===================================================
      

     /**
     * ShowMyPaymentsthis method serve to display the payments of the enseignant Who just logged in .
     * @param  int  $id User_id de l'Enseignant !!!!!! we can use auth()->user()->id ;
     * @return /// all the payments of the enseignant Who just logged in  
     */
           
       public function ShowMyPayments($id)

          {      

                 $ens=Enseignant::where('user_id',$id)->with('paiements')->get();                          
                 return response()->json($ens);
          }
   


//============================================ The access is retricted for:Enseignant  =====================================================              
        
   
     /**
     * UploadMyImage this method serve to upload the Profil picture of the enseignant Who just logged inr.
     * @param  int  $id User_id of the Enseignant  !!!!!!
     * @return //success message that mean the picture was successfully uploaded .
     */
  
       public function UploadMyImage( Request $request,$id)
       
          {

                 $request->validate([ 'image'=>'required|max:1024|mimes:png,jpg,png' ]);

                 $enseignant=Enseignant::where('user_id',$id)->first();
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
//==================================== The access is retricted for:Enseignant   ============================================================                
           
   
     /**
     * ShowMyProfil this method serve to display the informations of the enseignant Who just logged in.
     * @param  int  $id User_id of the Enseignant !!!!!!
     * I used  EnseignantResource class that serve to filter the data .
     */

       public function ShowMyProfil($id)
          {
                 return new EnseignantResource(Enseignant::where('user_id',$id)->with('etablissement','grade')->first());
          }

//======================================= The access is retricted for:Enseignant ======================================= 


     /**
     * MyHours this method serve count The hours worked for a specified enseignant .
     * @param  int  $id  ID Enseignant !!!!!!
     * I used  EnseignantResource class that serve to filter the data .
     */
       public function MyHours ($id)

          {
                 $enseignant=new Enseignant();
                 return response()->json($enseignant->Hours($id));
          }

//==================================== The access is retricted for:Enseignant ============================================


     /**
     * UpdateMyEmail() this method serve to update the email of the enseignant Who just logged in.
     * @param  int  $id User_id of the directeur  !!!!!!
     * @param  UpdateEnseignantRequest contain the validation rules of the data .
     * @return //a success message that mean the email of the enseignant was successfully updated.
     */

       public function UpdateMyEmail( UpdateEnseignantRequest $request ,$id)

          {
                 $enseignant=Enseignant::where('user_id',$id)->first();  
                 $enseignant->email_perso=$request['email_perso'];   
                 $enseignant->save();  
                 return $this->succes("","email updated successfully");
          }

                
// 
}

