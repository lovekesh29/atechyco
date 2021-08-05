<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class NewsLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsLetter;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newsLetter)
    {
        $this->newsLetter = $newsLetter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.newsLetter');
    }
}
