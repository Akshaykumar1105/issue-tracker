<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IssueStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    private $issue;
    private $user;
    /**
     * Create a new message instance.
     */
    public function __construct($issue, $user)
    {
        $this->issue = $issue;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $sendForReview = $this->issue->status == 'SEND_FOR_REVIEW';

        // Set the subject based on the condition
        $subject = $sendForReview ? 'Issue Report Submission' : 'Issue status changed';

        return new Envelope(
            subject: $subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.issue-status-changed',
            with: ['issue' => $this->issue, 'user' => $this->user]
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
