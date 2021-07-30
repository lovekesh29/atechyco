<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $contactDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactDetails)
    {
        $this->contactDetails = $contactDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->contactDetails->email, $this->contactDetails->fullName)
                ->view('mail.contactUsAdmin');
    }
}
