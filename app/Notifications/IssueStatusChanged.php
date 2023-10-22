<?php

namespace App\Notifications;

use App\Mail\IssueStatusChanged as MailIssueStatusChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IssueStatusChanged extends Notification
{
    use Queueable;

    protected $issue;
    protected $user;
    /**
     * Create a new job instance.
     */
    public function __construct($issue, $user)
    {
        $this->issue = $issue;
        $this->user = $user;
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
        return (new MailIssueStatusChanged($this->issue, $this->user))->to($this->user->email);
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
