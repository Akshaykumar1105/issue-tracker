<?php

namespace App\Jobs;

use App\Notifications\ManagerCredential as NotificationsManagerCredential;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ManagerCredential implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $password;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
           $this->user->notify(new NotificationsManagerCredential($this->user, $this->password));
        } catch (\Exception $e) {
            Log::error("Error processing Manager Credential job: " . $e->getMessage());
        }
    }
}
