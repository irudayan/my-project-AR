<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class annual extends Mailable
{
   use Queueable, SerializesModels;

    public $bodyContent;
    public $userContent;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bodyContent,$userContent)
    {
        $this->bodyContent = $bodyContent;
        $this->userContent = $userContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New User Register Verification !')
            ->view('frontend.email.annual');

    }
}
