<?php

namespace App\Notifications;

use App\Mail\SendIssueCreatorNotification as MailSendIssueCreatorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendIssueCreatorNotification extends Notification
{
    use Queueable;

    private $issue;
    /**
     * Create a new notification instance.
     */
    public function __construct($issue)
    {
        $this->issue = $issue;
        
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
    public function toMail(object $notifiable)
    {
        return (new MailSendIssueCreatorNotification($this->issue))->to($this->issue->email);
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
