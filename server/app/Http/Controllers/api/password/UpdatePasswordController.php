<?php

namespace App\Http\Controllers\api\password;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    use HttpResponses;

    public function UpdatePassword(UpdatePasswordRequest $request, $user_id)
    {
        $old_pass = $request->password;
        $user=User::find($user_id);
        $passwd=$user->password;

        // Verify if the current password is correct
        if (!password_verify($old_pass,$passwd)) {
            return $this->error("","Le mot de passe actuel est incorrect.",400);
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
public function InfoUser($user_id){
    if (auth()->user()->role == 4 &&  auth()->user()->id == $user_id) {

        $data = Enseignant::where('user_id', $user_id)->first();
        $enseignant = ['nom' => $data->nom,'prenom'=>$data->prenom,'email_perso'=>$data->email_perso];
        return $this->succes($enseignant, "Informations");
    }
    if (auth()->user()->role == 2 &&  auth()->user()->id == $user_id) {

        $data = Administrateur::where('user_id', $user_id)->first();
        $admin = ['nom' => $data->nom,'prenom'=>$data->prenom,'email_perso'=>$data->email_perso];
        return $this->succes($admin, "Informations");
    }
    if (auth()->user()->role == 1 &&  auth()->user()->id == $user_id) {

        $data = Directeur::where('user_id', $user_id)->first();
        $directeur = ['nom' => $data->nom,'prenom'=>$data->prenom,'email_perso'=>$data->email_perso];
        return $this->succes($directeur, "Informations");
    }
}
}
