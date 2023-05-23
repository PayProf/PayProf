<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;
   
    protected $password;
    
    

    /**
     * Create a new notification instance.
     */
    public function __construct($password)
    {
        $this->password = $password;
        
        


    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Bonjour')
            ->line('Vous avez été enregistré avec succès.')
            ->line('Voici votre mot de passe : ' . $this->password)
            ->line('Veuillez le conserver en toute sécurité.')
            ->line('Merci de votre inscription !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
