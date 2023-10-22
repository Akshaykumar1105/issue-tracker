<?php

namespace App\Jobs;

use App\Models\Issue;
use App\Models\User;
use App\Notifications\SendIssueCreatorNotification as NofitySendIssueCreatorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendIssueCreatorNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $user;
    /**
     * Create a new job instance.
     */
    public function __construct($email, $user)
    {
        $this->email = $email;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $issue = Issue::where('email', $this->email)->first();
            if ($issue) {
                $issue->notify(new NofitySendIssueCreatorNotification($issue));
            } else {
                Log::warning("User with email {$this->email} not found.");
            }
        } catch (\Exception $e) {
            Log::error("Error processing ConfirmPassword job: " . $e->getMessage());
        }
    }
}
