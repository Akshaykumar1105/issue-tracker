<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\User;
use App\Notifications\IssueReportSubmission as NotificationsIssueReportSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class IssueReportSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
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
        // try {
        //     $user = Company::where('email', $this->email)->first();
        //     if ($user) {
        //         $user->notify(new NotificationsIssueReportSubmission($user));
        //     } else {
        //     }
        // } catch (\Exception $e) {
        //     Log::error("Error processing ConfirmPassword job: " . $e->getMessage());
        // }
        $user = Company::where('email', $this->email)->first();
            if ($user) {
                // dd($user);
                $user->notify(new NotificationsIssueReportSubmission($user));
            } else {
                dd(3);
            }
    }
}