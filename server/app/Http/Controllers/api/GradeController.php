<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GradeController extends Controller
{
   //=====================================================The access is retricted for :AdminUAE| AdminEtab| President | DirecteurEtab ======================================================



   /**
    * Index() this methode serve to display all the grades.
    *
    * @return /all the information of all  grades 
    */

   public function index()
   {
      return GradeResource::collection(Grade::latest()->paginate(10));
   }


   //======================================================================= The access is retricted for :AdminUAE| AdminEtab =============================================================================================   


   /**
    * Store it's a method taht serve to add a new grade .
    * @param StoreGradeRequest it's a class that contains the validation rules. 
    * @return / a success message which mean the grade was successfully added
    */
   public function store(StoreGradeRequest $request)
   {

      if (Gate::allows('check_role', [4])) {

         $grade = new GradeResource(Grade::create($request->all()));
         if ($grade) {
            return response()->json(["message" => "added successfuly"]);
         }
      }
      // @AnasChatt : Fixed merge problem
      return $this->error('', 'ACCES INTERDIT ', 403);
   }


   //================================================================================== The access is retricted for :AdminUAE| AdminEtab  ============================================


   /**
    * show this method serve to display the data of a  specified grade.
    * @param  int  $id GradeID !!!!
    * @return /the information of the specified Grade.
    */
   public function show($id)
   {


      return new GradeResource(Grade::findOrFail($id));
   }


   //========================================================================================= The access is retricted for : AdminUAE | AdminEtab  ============================================================        

   /**
    * Update this method serve to update the information of a specified Grade.
    *
    * @param  UpdateGradeRequest this class contains the validation rules.
    * @param  int  $id IDGRADE !!!!!!
    * @return // an error message in case of invalid Id // success message that mean the informations of the specified Grade are updated successfully
    */
   public function update(UpdateGradeRequest $request, $id)
   {
      if (Gate::allows('check_role', [4])) {
         Grade::findOrFail($id)->update($request->all());
         return response()->json(["message" => " Updated successfully"]);
      }
      return $this->error('', 'ACCES INTERDIT ', 403);
   }



   //================================================================== The access is retricted for : AdminUAE| AdminEtab ====================================================================


   /**
    * destroy serve to remove the specified grade from storage.
    * @param  int  $id IDGRADE!!!!!
    * @return /// an error message in case of invalid Id // success message that mean the informations of the specified Grade are updated successfully
    */
   public function destroy($id)
   {
      if (Gate::allows('check_role', [4])) {
         $grade = Grade::FindOrFail($id);
         if ($grade) {
            $grade->delete();
            return response()->json(["message" => "deleted successfuly"]);
         }
      }
      return $this->error('', 'ACCES INTERDIT ', 403);
   }
}



//================================================ SMEH LINA A KHOYA REDA SBER M3ANA ================================================================




// ======================================================= YOUSSEF HARRAK =========================================================================