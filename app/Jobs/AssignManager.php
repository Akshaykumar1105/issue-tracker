<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\AssignManager as NotificationsAssignManager;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;


class AssignManager implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $issue;
    /**
     * Create a new job instance.
     */
    public function __construct($email, $issue)
    {
        $this->email = $email;
        $this->issue = $issue;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = User::where('email', $this->email)->first();
            if ($user) {
                $user->notify(new NotificationsAssignManager($this->issue));
            } else {
                Log::warning("User with email {$this->email} not found.");
            }
        } catch (\Exception $e) {
            Log::error("Error processing Assign Manager job: " . $e->getMessage());
        }
    }
}
