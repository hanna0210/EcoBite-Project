<?php

namespace App\Http\Livewire\Extensions\Emailer\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Livewire\Extensions\Emailer\Mail\CustomEmailerMail;

class SendCustomEmailerMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $title;
    protected $body;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $title, $body)
    {
        $this->email = $email;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            \Mail::to($this->email)->send(new CustomEmailerMail($this->title, $this->body));
            \Log::info("Email sent successfully to: {$this->email}");
        } catch (\Exception $e) {
            \Log::error("Failed to send email to {$this->email}: " . $e->getMessage());
            throw $e;
        }
    }
}
