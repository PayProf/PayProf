<?php

namespace App\Http\Controllers\api\password;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class UpdatePasswordController extends Controller
{
    use HttpResponses;

    public function UpdatePassword(UpdatePasswordRequest $request,$user_id){
     $user=User::find($user_id);
     if($user){
       if($user){
       $user->password=$request->password;
       $data=$user->save();
       $this->succes($data,"SUCCESSFLY UPDATED");
       }else{
        $this->succes("","");
       }
     }
     else{
        $this->error("","NO USER ID FOUND",404);
     }
    }
     
}
