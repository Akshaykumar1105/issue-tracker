<?php

namespace App\Jobs;

use App\Mail\ReviewIssue as MailReviewIssue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ReviewIssue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reviewIssue;
    /**
     * Create a new job instance.
     */
    public function __construct($reviewIssue)
    {
        $this->reviewIssue = $reviewIssue;
    }

    /**
     * Execute the job.
     */
    public function handle(): void{
        $issue = new MailReviewIssue($this->reviewIssue['issue']);
        Mail::to($this->reviewIssue['email'])->send($issue);
    }
}
