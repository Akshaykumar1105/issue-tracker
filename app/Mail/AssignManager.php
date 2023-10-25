<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssignManager extends Mailable
{
    use Queueable, SerializesModels;

    private $issue;
    /**
     * Create a new message instance.
     */
    public function __construct($issue)
    {
        $this->issue = $issue;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Assign Issue | Issue Tracker',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // dd(3);
        return new Content(
            view: 'email.assign-manager',
            with: ['issue' => $this->issue]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
