<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\ConfirmPassword as NotificationsConfirmPassword;

class ConfirmPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('email', $this->email)->first();
        try {
            if ($user) {
                $user->notify(new NotificationsConfirmPassword($user->email));
            } else {
                Log::warning("User with email {$this->email} not found.");
            }
        } catch (\Exception $e) {
            Log::error("Error processing ConfirmPassword job: " . $e->getMessage());
        }
    }
}
