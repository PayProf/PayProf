<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginUserRequest;

use App\Notifications\LoginNotification;
use App\Traits\HttpResponses;

use App\Models\User;

use Illuminate\Support\Facades\Auth;





class AuthController extends Controller
{
    use HttpResponses;
    
    public function login(LoginUserRequest $request){
        $request->validated($request->all());
        if (!Auth::attempt($request->only('email', 'password'))){
            return $this->error('','Credentials do not match',401);
        }
       
        $user=user::where('email',$request->email)->first();
       
        $emailToken = hash('sha256', $user->email);
        return $this->succes([
            'user'=>$user,
            'token'=>$user->createToken('API Token of '.$user->name,[
                'email' => $emailToken,
                 'id' => $user->id
            ])->plainTextToken
           
        

        ]);
        
        
       
       
        
       
    }
    

   

    public function logout(){
        

        auth()->user()->tokens()->delete();

        return $this->succes(
            [
                'message'=>'SUCCESSFLY LOG OUT '
            ]
            );

    }
 
}

