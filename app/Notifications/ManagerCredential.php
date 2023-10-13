<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ManagerCredential extends Notification
{
    use Queueable;

    protected $email;
    protected $password;


    /**
     * Create a new notification instance.
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
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
            ->subject('Manager Credentials')
            ->line('Hello,')
            ->line('Here are the login credentials for the manager:')
            ->line('Email: ' . $this->email)
            ->line('Password: ' . $this->password)
            ->line('Please use these credentials to access the managers account. ')
            ->action('Login', url('/login'))
            ->line('If you have any questions or need assistance, please feel free to contact us.')
            ->line('Thank you!');
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
