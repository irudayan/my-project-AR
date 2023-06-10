<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class contactus extends Mailable
{
   use Queueable, SerializesModels;

    public $bodyContent;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bodyContent)
    {
        $this->bodyContent = $bodyContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $subject = $this->bodyContent['subject'];
        return $this->subject($subject)
            ->view('frontend.email.sendmessage');

    }
}
