<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdvertDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $advert;
    

   
    public function __construct($advert)
    {
        $this->advert = $advert;
       
    }

    
    public function build()
    {
        return $this->subject('Your advert has been deleted')
                    ->view('emails.advert_deleted')
                    ->with([
                        'advert' => $this->advert,
                       
                    ]);
    }
}
    

