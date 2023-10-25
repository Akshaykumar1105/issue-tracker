<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\IssueSolve as MailIssueSolve;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class IssueSolve implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $issueSolve;
    /**
     * Create a new job instance.
     */
    public function __construct($issueSolve){
        $this->issueSolve = $issueSolve;
    }

    /**
     * Execute the job.
     */
    public function handle(): void{
        try {
            $uuid = new MailIssueSolve($this->issueSolve['issue']);
            Mail::to($this->issueSolve['email'])->send($uuid);
        } catch (\Exception $e) {
            Log::error("Error processing issue solve job: " . $e->getMessage());
        }
       
    }
}
