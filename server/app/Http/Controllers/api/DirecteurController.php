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
    // A class that handles the success and error messages
    use HttpResponses;
   
    
 //=========================================The access is retricted for:AdminUAE||President ================================================
   
 
    /**
     * Indexe() it's a methode that serve to display all the directors with there etablissement.
     * I used in this method DirecteurResource that serve to filter the data .
     * @return mixed the important data of all directeurs such as :(Nom|prenom|etablissement......) .
    */
   
    public function index()
    {
        return DirecteurResource::collection(Directeur::with('etablissement')->latest()->paginate(5));
    }

   
//============================================The access is retricted for:AdminEtab ===========================================================================   
   

    /**
     * Store() it's a method that serve to add a new directeur.
     * @param  StoreDirecteurRequest / it's a class that serve to validate the data before the insert.
     * @return  / a success message that mean the  new directeur was successfully inserted 
     * Attention the comments in this method must be respected 
     */
    
     public function store(StoreDirecteurRequest $request)
     
     {
            $directeur=new Directeur();
            $request['IdEtablissement']=1;                                                                  // auth()->user()->administrateur->etablissement_id//the security developper should approuve it
            $directeur->PPR = $request['PPR'];
            $directeur->nom = $request['nom'];
            $directeur->prenom = $request['prenom'];
            $directeur->date_naissance = $request['DateNaissance'];
            $directeur->etablissement_id = $request['IdEtablissement'];
            //$directeur->user_id = $request['IdUser']                                                      // i talked with the postgres admin to add a trigger for this  ;
            $directeur->email_perso=$request['email_perso'];
            $directeur->save();
            return $this->succes("","added successfully");
     }

//=============================================The access is retricted for:AdminUAE|President|AdminEtab =============================================================    
    
    
    /**
     * Show() this method serve to display a specified directeur with the name and the city of his etablissement .
     * @param  int  $id it's ID Directeur!!!!!!
     * @return   // error message in case of invalid directeurid
     */
   
     public function show($id)
    {
             return new DirecteurResource(Directeur::with('etablissement')->FindOrFail($id));
   
    }

//===============================================The access is retricted for:AdminEtab =====================================
    

    /**
     * Update() this method serve to update the information of a specified directeur.
     * @param  UpdateDirecteurRequest contain the validation rules of the data .
     * @param  int  $id ID directeur!!!!!!!!!!!
     * @return  //a success message that mean the data of the directeur was successfully updated. 
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

//===========================================The access is retricted for:AdminEtab =====================================================
   
   
    /**
     * Destroy() this method serve to remove a specified directeur.
     * @param  int  $id IDDIRECTEUR !!!!!!
     * @return ///a success message that mean the directeur was successfully deleted. 
     */
      
     public function destroy($id)
    {
        $directeur=Directeur::FindOrfail($id);   
        $directeur->delete();
        unlink(public_path('uploads').'/'.$directeur->image);                                               //destroy the appropriate image .     
        return $this->succes("","Directeur deleted successfully");
    }


/*=============================================The access is retricted for:Directeur======================================================================*/

   
    /**
     * UpdateMyEmail() this method serve to update the email of a specified directeur.
     * @param  int  $id User_id of the directeur  !!!!!!
     * @param  UpdateDirecteurRequest contain the validation rules of the data .
     * @return //a success message that mean the email of the directeur was successfully updated.
     */
   
       public function UpdateMyEmail( UpdateDirecteurRequest $request ,$id)
              
       {
               $directeur=Directeur::where('user_id',$id)->first();             
               $directeur->email_perso=$request['email_perso'];             
               $directeur->save();             
               return $this->succes("","email updated successfully");
        }


//==============================================The access is retricted for:Directeur =====================================
   
   
    /**
     * ShowMyProfil this method serve to display the informations of the directeur Who just logged in.
     * @param  int  $id User_id of the directeur  !!!!!!
     * I used in this method DirecteurResource that serve to filter the data .
     */

       public function ShowMyProfil($id)
      
       {
             return new DirecteurResource(Directeur::where('user_id',$id)->with('etablissement')->first());
       
        }
    
//===============================================The access is retricted for:Directeur====================================
      
   
    /**
     * UploadMyImage this method serve to upload the Profil picture of the directeur Who just logged inr.
     * @param  int  $id User_id of the directeur  !!!!!!
     * @return //success message that mean the picture was successfully uploaded .
     */

        public function UploadMyImage( Request $request,$id)
       
        {

            $request->validate([ 'image'=>'required|max:1024|mimes:png,jpg,png' ]);

            $directeur=Directeur::where('user_id',$id)->first();
            if($request->hasFile('image'))
            {
            $file=$request->image;
            $image_name=time().'_'. $file->getClientOriginalName();
            $file->move(public_path('uploads'),$image_name);                 
           
// ===================== if the directeur already has a ProfilPicture =======================================
            if($directeur->image)
            { unlink(public_path('uploads'). '/' .$directeur->image); }                 
            $directeur->image=$image_name;
            $result=$directeur->save();
            } 
// =================================== Si le resultat est true ==============================================                          
            if($result)
            {
              return $this->succes("","image uploaded successfully");    
            }
 
                   
         }           


//================================================ SMEH LINA A KHOYA REDA SBER M3ANA ==========================================




// ======================================================= YOUSSEF HARRAK ===========================================
}
