<?php

namespace App\Http\Controllers\api;
use App\Http\Resources\EnseignantResource;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnseignantRequest;
use App\Http\Requests\UpdateEnseignantRequest;
use App\Http\Resources\EnseignantInterventionResource;
use App\Models\Enseignant;


use App\Traits\HttpResponses;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
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
                 $grade_id=$enseignant->IdGrade($request['Grade']);//IdGrade() it's a method that return the id of the grade 
                 $etablissement_id=1;//auth()->user()->administrateur->etablissement_id // //the security developper should approuve it
                 $enseignant->PPR = $request['PPR'];
                 $enseignant->nom = $request['nom'];
                 $enseignant->prenom = $request['prenom'];
                 $enseignant->date_naissance = $request['DateNaissance'];
                 $enseignant->etablissement_id = $etablissement_id;
                 $enseignant->grade_id =$grade_id;  //
                 // $enseignant->user_id = $request['IdUser'];// i talked with the postgres admin to add a trigger for this  ;
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
                 //$ens= Enseignant::with('grade','etablissement')->where('id',$id)->get();
                 //return response()->json($ens);
          }
        
     
//=========================================================== The access is retricted for:AdminUEtab|AdminUae===============================================
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function update( UpdateEnseignantRequest $request, $id)
                {   
                
                               //the class UpdateEnseignantRequest handles both PUT and Patch Request(for more details check the class  ) 
                      
                                   $enseignant=Enseignant::find($id);
                                   $grade_id=$enseignant->IdGrade($request['Grade']);  
                                   $enseignant->PPR = $request['PPR'];
                                   $enseignant->nom = $request['nom'];
                                   $enseignant->prenom = $request['prenom'];
                                   $enseignant->date_naissance = $request['DateNaissance'];
                                   $enseignant->grade_id=$grade_id;
                                   $enseignant->email_perso=$request['email_perso'];
                                   //dd($enseignant);
                                   $enseignant->save();
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
                                // findorfail send a error msg in case of the entry of invalid id
                                $ens= Enseignant::FindOrfail($id);
                                
                                unlink(public_path('uploads').'/'.$ens->image);
                                
                                $ens->delete();
                        
                                // success msg 
                                return $this->succes("","enseignant deleted successfully");
                
                }

                public function ShowMyInterventions($id)

                {                //I think this methods will make the process or the tasks much more easier to the manager of security 
                                //$ensint=Enseignant::with('interventions.etablissement')->find($id);
                                //return response()->json($ensint);
                
                                //this method display all the interventions of a specified prof
                                // attention  10 doit etre remplacée par  atttttttention  auth()->user()->id
                                     //  auth()->user()->id  
                                return  EnseignantInterventionResource::collection (Enseignant::where('user_id',$id)->with('interventions.etablissement')->get());
                                                                                                //  auth()->user()->id                          
                              // return response()->json(  dd(Enseignant::with('interventions.etablissement')->where('user_id','=',4))));
                              // return Enseignant::where('user_id','=',4)->with('interventions.etablissement')->get();
                        
                }

                public function ShowMyPayments($id)
                {            //  auth()->user()->id ;
                      $ens=Enseignant::where('user_id',$id)->with('paiements')->get();
                                           
                      return response()->json($ens);

                }
   

               //this method is specially for the adminEtab
//                 public function MyEtabProf()
//                 { 
//                   $id=7;                       //auth()->user()->administrateur->etablissement_id;
//                   return EnseignantResource::collection(Enseignant::where('etablissement_id','=',$id)->with('etablissement','grade')->latest()->paginate(10)); 

//                 }
               public function UploadMyImage( Request $request,$id)
               {

                         $request->validate(
                              [
                                   'image'=>'required|max:1024|mimes:png,jpg,png'
                                  
                               ]
                              );


                            $ens=Enseignant::where('user_id',$id)->first();
                            if($request->hasFile('image'))
                         { 
                              $file=$request->image;
                              $image_name=time().'_'. $file->getClientOriginalName();
                              $file->move(public_path('uploads'),$image_name);
                             
                             
                              if($ens->image)
                         {
                              unlink(public_path('uploads'). '/' .$ens->image);
                         }
                              
                              $ens->image=$image_name;
                              $result=$ens->save();
                         }
                              
                         if($result)
                         {
                              return $this->succes("","image uploaded successfully");    
                         }
 
                   
               }


               public function ShowMyProfil($id)
               {
                    return new EnseignantResource(Enseignant::where('user_id',$id)->with('etablissement','grade')->first());
               }

              
               public function MyHours ($id)
               {
                    $ens=DB::table('interventions')->where('enseignant_id',$id)->sum('Nbr_heures');
                    
                    return response()->json(["hours"=>$ens]);
               }



               public function UpdateMyEmail( UpdateEnseignantRequest $request ,$id)
               {

                    $ens=Enseignant::where('user_id',$id)->first();
                    
                    $ens->email_perso=$request['email_perso'];
                    
                    $ens->save();
                   
                    return $this->succes("","email updated successfully");

               }

                
// 
}