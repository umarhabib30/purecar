<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Welcome to PureCar – A Better Way to Buy & Sell Cars in NI!')
                    ->replyTo($this->data['email'])
                    ->view('emails.welcome')
                    ->with('data', $this->data);
    }
}
