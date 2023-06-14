<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginUserRequest;

use App\Notifications\LoginNotification;
use App\Traits\HttpResponses;

use App\Models\User;

use Carbon\Carbon;
use Dotenv\Util\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\PersonalAccessToken;






class AuthController extends Controller
{
    use HttpResponses;
   
    public function login(LoginUserRequest $request)
{
    // Valider la requête en utilisant les règles définies dans LoginUserRequest
    $request->validated($request->all());

    // Authentifier l'utilisateur en utilisant les identifiants fournis (email et mot de passe)
    if (!Auth::attempt($request->only('email', 'password'))) {
        return $this->error('','Credentials do not match', 401);
    }

    // Récupérer l'utilisateur authentifié
    $user = User::where('email', $request->email)->first();

    // Vérifier s'il existe des jetons valides pour cet utilisateur
    $validTokens = $user->tokens()
        ->where('expires_at', '>', now())
        ->count();
    if ($validTokens > 0) {
        return $this->error('','Utilisateur déjà connecté', 409);
    }

    // Créer un jeton d'accès pour l'utilisateur
    $token = $user->createToken('token_user')->plainTextToken;

    // Mettre à jour la date d'expiration du jeton d'accès
    $personalAccessToken = PersonalAccessToken::findToken($token);
    $personalAccessToken->expires_at = Carbon::now()->addHours(6);
    $personalAccessToken->save();

    // Retourner la réponse réussie avec le rôle de l'utilisateur et le jeton d'accès
    return $this->succes([
        'id' => $user->id,
        'role' => $user->role,
        'token' => $token,
       
    ], 'SUCCESSFULLY LOGIN');
}

    


    public function logout(){
        
        // Supprimer tous les tokens d'authentification de l'utilisateur actuellement authentifié
        auth()->user()->tokens()->delete();
         // Retourner la réponse de succès indiquant que la déconnexion s'est déroulée avec succès
        return $this->succes('','SUCCESSFLY LOGOUT');

    }


    public function refreshToken()
  {
    // Récupérer l'utilisateur authentifié
    $user = auth()->user();

    // Supprimer tous les jetons d'accès de l'utilisateur
    $user->tokens()->delete();

    // Créer un nouveau jeton d'accès pour l'utilisateur
    $token = $user->createToken('token-name')->plainTextToken;

    // Mettre à jour la date d'expiration du jeton d'accès
    $personalAccessToken = PersonalAccessToken::findToken($token);
    $personalAccessToken->expires_at = Carbon::now()->addHours(6);
    $personalAccessToken->save();

    // Retourner la réponse réussie avec le nouveau jeton d'accès
    return $this->succes([
        'token' => $token
    ], 'SUCCESSFULLY refreshToken');
   }


   














    





    

 
}

