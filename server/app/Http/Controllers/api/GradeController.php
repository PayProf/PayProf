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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
        {
            //display all the grades with a pigination of 10 grades/page 
             return GradeResource::collection(Grade::latest()->paginate(10));
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradeRequest $request)
        {
            //this method store the data entered by the admin
            $grade= new GradeResource(Grade::create($request->all()));
            if($grade)
            {
                return response()->json(["message"=>"added successfuly"]);
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
            //generate a error msg in case of we enter the incorrect id 
            return new GradeResource(Grade::findOrFail($id));
        
        }

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
