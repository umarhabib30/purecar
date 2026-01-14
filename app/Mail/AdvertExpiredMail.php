<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdvertExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $advertTitle;
    public $expiryDate;

    
    public function __construct($userName, $advertTitle, $expiryDate)
    {
        $this->userName = $userName;
        $this->advertTitle = $advertTitle;
        $this->expiryDate = $expiryDate;
    }

   
    public function build()
    {
        return $this->subject('Your advert has expired')
                    ->view('emails.advert_expired')
                    ->with([
                        'userName' => $this->userName,
                        'advertTitle' => $this->advertTitle,
                        'expiryDate' => $this->expiryDate,
                    ]);
    }
}
