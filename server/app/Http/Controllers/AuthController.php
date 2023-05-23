<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginUserRequest;

use App\Notifications\LoginNotification;
use App\Traits\HttpResponses;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;





class AuthController extends Controller
{
    use HttpResponses;
    protected $email;
    protected $role;
    
   /* public function __construct($email,$role){
      $this->email=$email;
      $this->role=$role;
    }*/
    public function login(LoginUserRequest $request){
        // Valider les données de la requête
        $request->validated($request->all());
         // Vérifier les informations d'identification
        if (!Auth::attempt($request->only('email', 'password'))){
            return $this->error('','Credentials do not match',401);
        }
       // Récupérer l'utilisateur correspondant à l'e-mail fourni
        $user=user::where('email',$request->email)->first();
       
       // Retourner la réponse de succès(role du user+token) indiquant que la connexion s'est déroulée avec succès
        return $this->succes([
            'role'=>$user->role,
            'token'=>$user->createToken('API Token of '.$user->name
            )->plainTextToken
           
        

        ],'SUCCESSFLY LOGIN');
        
        
       
       
        
       
    }
    public function logout(){
        
        // Supprimer tous les tokens d'authentification de l'utilisateur actuellement authentifié
        auth()->user()->tokens()->delete();
         // Retourner la réponse de succès indiquant que la déconnexion s'est déroulée avec succès
        return $this->succes('','SUCCESSFLY LOGOUT');

    }

    public function refreshToken()
{
    $user = auth()->user();

    // Supprimer tous les tokens existants de l'utilisateur
    $user->tokens()->delete();

    // Créer un nouveau token pour l'utilisateur
    $newToken = $user->createToken('API Token of ' . $user->name)->plainTextToken;

    return $this->succes([
        
        'token' => $newToken
    ],'SUCCESSFLY refreshToken');
}




    /*public function register($email,$role){
        
        
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
        $password = substr(str_shuffle($chars), 0, 12);
        echo $password;
        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role
        ]);

       
    }*/
    

   

   
 
}

