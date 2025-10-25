<?php

namespace App\Http\Livewire\Extensions\Emailer\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomEmailerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $body;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)->view('livewire.extensions.emailer.email.custom_emailer_mail', [
            "body" => $this->body
        ]);
    }
}
