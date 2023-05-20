<?php
namespace App\Traits;

trait HttpResponses{
    protected function succes($data,$message=null,$code=200){
        return response()->json(
            [
                'status'=>'REQUEST WAS SUCCEFUL',
                'message'=>$message,
                'data'=>$data
            ],$code);
    }
    protected function error($data,$message=null,$code){
        return response()->json(
            [
                'status'=>'ERROR',
                'message'=>$message,
                'data'=>$data
            ],$code);

          

           
    }
}