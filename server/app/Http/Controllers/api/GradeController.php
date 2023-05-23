<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Illuminate\Http\Request;

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
            
                 $grade= new GradeResource(Grade::create($request->all()));
                 if($grade)
                 {
                 return response()->json(["message"=>"added successfuly"]);
                 }
          }


//================================================================================== The access is retricted for :AdminUAE| AdminEtab  ============================================


    /**
     * show this method serve to display the data of a  specified grade.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
        {   
            
            return new GradeResource(Grade::findOrFail($id));
        
        }

//========================================================================================= ============================================================        

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGradeRequest $request, $id)
        {
            
            //the class UpdateGradeRequest handles both PUT and Patch Request(for more details check the class  )
            //the error msg will appear in case of incorrect identifier
            Grade::findOrFail($id)->update($request->all());

        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
        {
            $grade=Grade::FindOrFail($id);
            if($grade)
            {
                $grade->delete();
                return response()->json(["message"=>"deleted successfuly"]);
            }
        }
}
