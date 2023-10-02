<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $resetPassword;
    /**
     * Create a new job instance.
     */
    public function __construct($resetPassword){
        $this->resetPassword = $resetPassword;
        $this->onQueue('high');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // dd($this->resetPassword);
        $token = new ResetPasswordEmail($this->resetPassword['token']);
        Mail::to($this->resetPassword['email'])->send($token);
    }
}
