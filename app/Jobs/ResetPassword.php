<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class ResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $resetPassword;
    /**
     * Create a new job instance.
     */
    public function __construct($resetPassword){
        $this->resetPassword = $resetPassword;
    }

    /**
     * Execute the job.
     */
    public function handle(): void{
        try{
            $user = User::where('email', $this->resetPassword['email'])->first();
            $token = new ResetPasswordEmail($this->resetPassword['token'], $user);
            Mail::to($this->resetPassword['email'])->send($token, $user);
        }catch (\Exception $e) {
            Log::error("Error processing Issue status changed job: " . $e->getMessage());
        }
    }
}
