<?php

namespace App\Jobs;

use App\Notifications\IssueStatusChanged as NotificationsIssueStatusChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class IssueStatusChanged implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if ($this->issue) {
                if($this->issue->manager){
                    $this->user->notify(new NotificationsIssueStatusChanged($this->issue, $this->user));
                }
            } else {
                Log::warning("User with email {$this->issue->manager->email} not found.");
            }
        } catch (\Exception $e) {
            Log::error("Error processing Issue status changed job: " . $e->getMessage());
        }
    }
}
