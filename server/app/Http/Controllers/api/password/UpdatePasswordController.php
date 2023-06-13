<?php

namespace App\Http\Controllers\api\password;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePasswordRequest;

class UpdatePasswordController extends Controller
{
    use HttpResponses;

    public function update(UpdatePasswordRequest $request, $user_id)
    {
        $old_pass = bcrypt($request->password);

        // Get the authenticated user
        $user = Auth::user();

        // Verify if the current password is correct
        if ($request->password != $user->password) {
            return $this->error("","Le mot de passe actuel est incorrect.",400);
        }

        // Verify if the new password and password confirmation match
        if ($request->new_password != $request->new_password_confirmation) {
            return $this->error("","Le nouveau mot de passe et le mot de passe de confirmation ne correspondent pas.",400);
        }

        // Encrypt the new password
        $encryptedPassword = bcrypt($request->new_password);

        // Update the password in the database
        $user = User::find($user_id);
        if ($user) {
            $user->password = $encryptedPassword;
            $user->save();

            return $this->succes("","Le mot de passe a été mis à jour avec succès.");
        } else {
            return $this->error("","Aucun utilisateur trouvé avec cet ID.",404); 
        }
    }

    public function deleteAccount()
{ 
    $user = Auth::user();

    if ($user) {
        $user->delete();
        return $this->succes("","Le compte a été supprimé avec succès.");
    } else {
        return $this->error("","Aucun utilisateur authentifié trouvé.",404);
    }
}
     
}