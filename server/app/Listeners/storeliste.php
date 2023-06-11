<?php

namespace App\Listeners;

use App\Events\storeuser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LoginNotification;



class storeliste
{
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\storeuser  $event
     * @return void
     */
    public function handle(storeuser $event) 
    {
        
        // Création de l'email unique basé sur le nom et prénom fournis
    $baseEmail = strtolower($event->prenom . '.' . $event->nom . '@payprof.com');
    $uniqueEmail = $baseEmail;
    $count = 1;

    // Vérifier si l'email est déjà utilisé, si oui, ajouter un nombre à l'email pour le rendre unique
    while (User::where('email', $uniqueEmail)->exists()) {
        $uniqueEmail = substr($baseEmail, 0, strrpos($baseEmail, '@')) . $count . '@payprof.com';
        $count++;
    }

    // Générer un mot de passe aléatoire
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
    $password = substr(str_shuffle($chars), 0, 12);
    
    
    
    // Création de l'utilisateur dans la base de données
    $user = User::create([
        'email' =>  $uniqueEmail ,
        'password' => bcrypt($password),
        'role' => $event->role
    ]);
    
    // Envoyer une notification par e-mail avec le mot de passe généré à l'adresse fournie
    Notification::route('mail', $event->email)
        ->notify(new LoginNotification($password, $uniqueEmail));

       // Retourner l'identifiant de l'utilisateur créé
    
       return $user->id;
    }
    
    
}
